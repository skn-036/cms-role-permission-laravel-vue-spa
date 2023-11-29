import { ref } from 'vue';
import axios, { AxiosError } from 'axios';
import useModalToast from './useModalToast';

const useHttpRequest = (path = '') => {
    const { showToast } = useModalToast();
    const loading = ref(false);
    const initialLoading = ref(true);
    const saving = ref(false);
    const updating = ref(false);
    const deleting = ref(false);

    const index = async (callback = null) => {
        try {
            loading.value = true;
            const response = await axios.get(path);
            loading.value = false;

            if (typeof callback === 'function') {
                callback(null, response);
            }
            initialLoading.value = false;

            if (response.data) {
                return response.data;
            }
            return [];
        } catch (error) {
            loading.value = false;
            return handleError(error, [], callback, false);
        }
    };

    const store = async (data, callback = null) => {
        try {
            saving.value = true;
            const response = await axios.post(path, data);
            saving.value = false;

            if (typeof callback === 'function') {
                callback(null, response);
            }

            if (response.data) {
                return response.data;
            }
            return null;
        } catch (error) {
            saving.value = false;
            return handleError(error, null, callback);
        }
    };

    const update = async (id, data, callback = null) => {
        try {
            updating.value = true;
            const response = await axios.patch(`${path}/${id}`, data);
            updating.value = false;

            if (typeof callback === 'function') {
                callback(null, response);
            }

            if (response.data) {
                return response.data;
            }
            return null;
        } catch (error) {
            updating.value = false;
            return handleError(error, null, callback);
        }
    };

    const destroy = async (id, callback = null) => {
        try {
            deleting.value = true;
            const response = await axios.delete(`${path}/${id}`);
            deleting.value = false;

            if (typeof callback === 'function') {
                callback(null, response);
            }

            if (response.status === 204) {
                return true;
            }
            return false;
        } catch (error) {
            deleting.value = false;
            return handleError(error, false, callback);
        }
    };

    const handleError = (
        error,
        returnValue,
        callback,
        showUnauthorizedToast = true,
    ) => {
        if (error instanceof AxiosError) {
            const errorData = error.response.data;
            if ([13333, 13334, 13335].includes(errorData?.errorCode)) {
                showToast(
                    `${errorData?.errorMessage}${
                        errorData?.errorText
                            ? `\r\n${errorData?.errorText}`
                            : ''
                    }`,
                    errorData?.errorCode === 13334 ? 'success' : 'error',
                );
            }

            if (
                showUnauthorizedToast &&
                error.response.status === 401 &&
                error.response.data?.message === 'Permission not granted.'
            ) {
                showToast(
                    `${error.response.data?.message}${
                        error.response.data?.permissions?.length
                            ? `\r\nRequired permissions: ${error.response.data?.permissions.join(
                                  ' or ',
                              )}`
                            : ''
                    }`,
                    'error',
                );
            }

            if (typeof callback === 'function') {
                callback(error);
            }
        }

        return returnValue;
    };

    return {
        loading,
        initialLoading,
        saving,
        updating,
        deleting,

        index,
        store,
        update,
        destroy,
    };
};

export default useHttpRequest;

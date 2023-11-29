import { ref } from 'vue';
import { defineStore } from 'pinia';

import useHttpRequest from '../composables/useHttpRequest';

const usePermissionsStore = defineStore('permissions', () => {
    const {
        index: getPermissions,
        loading: permissionsLoading,
        initialLoading: permissionsFirstTimeLoading,
    } = useHttpRequest('/permissions');

    const permissions = ref([]);
    const loadPermissions = async () => {
        const res = await getPermissions();
        permissions.value = res;
    };

    return {
        permissions,
        loadPermissions,
        permissionsLoading,
        permissionsFirstTimeLoading,
    };
});

export default usePermissionsStore;

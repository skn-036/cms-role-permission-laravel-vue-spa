<script setup>
import { computed, ref, watch } from 'vue';
import Slider from '../ui/Slider.vue';
import FormInput from '../ui/FormInput.vue';
import Button from '../ui/Button.vue';
import AuthorizationFallback from '../../components/page/AuthorizationFallback.vue';

import useUserStore from '../../store/useUserStore';
import useRoleStore from '../../store/useRoleStore';
import usePermissionStore from '../../store/usePermissionStore';

import useValidation from '../../composables/useValidation';
import useHttpRequest from '../../composables/useHttpRequest';
import useModalToast from '../../composables/useModalToast';
import useAuth from '../../composables/useAuth';

import * as yup from 'yup';

const props = defineProps({
    show: {
        type: Boolean,
        default: () => false,
    },
    permission: {
        type: [Object, null],
        default: () => null,
    },
});
const emit = defineEmits(['hide']);

const userStore = useUserStore();
const roleStore = useRoleStore();
const permissionStore = usePermissionStore();

const {
    store: createPermission,
    saving,
    update: updatePermission,
    updating,
} = useHttpRequest('/permissions');
const { runYupValidation } = useValidation();
const { showToast } = useModalToast();
const { isUserAuthenticated } = useAuth();

const requiredPermissions = computed(() => {
    if (!props.permission?.id) return ['permissions-all', 'permissions-create'];
    else return ['permissions-all', 'permissions-edit'];
});

const title = computed(() =>
    props.permission
        ? `Update permission "${props.permission?.name}"`
        : 'Add new permission',
);

const initialFormData = () => {
    return {
        name: null,
    };
};

const formData = ref(initialFormData());
const formErrors = ref({});

watch(
    () => props.show,
    () => {
        if (props.show) {
            if (props.permission?.id) {
                formData.value = Object.entries(initialFormData()).reduce(
                    (r, [key, val]) => {
                        if (props.permission[key])
                            return { ...r, [key]: props.permission[key] };
                        return { ...r, [key]: val };
                    },
                    {},
                );
            } else {
                formData.value = initialFormData();
                formErrors.value = {};
            }
        }
    },
);

const schema = yup.object().shape({
    name: yup.string().nullable().required(),
});

const onSubmit = async () => {
    if (saving.value || updating.value) return;

    let data = { ...formData.value };

    const { validated, errors } = await runYupValidation(schema, data);
    if (!validated) {
        formErrors.value = errors;
        return;
    }
    formErrors.value = {};

    const response = props.permission?.id
        ? await updatePermission(props.permission?.id, data)
        : await createPermission(data);

    if (response?.id) {
        showToast(
            `Permission ${
                props.permission?.id ? 'updated' : 'created'
            } successfully`,
        );

        permissionStore.loadPermissions();
        userStore.loadUsers();
        roleStore.loadRoles();
        isUserAuthenticated();

        emit('hide');
    }
};
</script>

<template>
    <Slider
        :show="show"
        :title="title"
        @hide="emit('hide')"
    >
        <AuthorizationFallback :permissions="requiredPermissions">
            <div class="mt-4 space-y-4">
                <FormInput
                    v-model="formData.name"
                    :focus="show"
                    label="Name"
                    :error="formErrors?.name"
                    required
                />

                <Button
                    :title="permission?.id ? 'Save' : 'Update'"
                    :loading-title="
                        permission?.id ? 'Saving...' : 'Updating...'
                    "
                    class="!w-full"
                    :loading="saving || updating"
                    key="submit-btn"
                    @click="onSubmit"
                />
            </div>
        </AuthorizationFallback>
    </Slider>
</template>

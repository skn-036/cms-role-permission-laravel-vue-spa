<script setup>
import { computed, ref, watch } from 'vue';
import Slider from '../ui/Slider.vue';
import FormInput from '../ui/FormInput.vue';
import FormLabelError from '../ui/FormLabelError.vue';
import VSelect from 'vue-select';
import Button from '../ui/Button.vue';
import AuthorizationFallback from '../../components/page/AuthorizationFallback.vue';

import useUserStore from '../../store/useUserStore';
import useRoleStore from '../../store/useRoleStore';
import usePermissionStore from '../../store/usePermissionStore';
import useValidation from '../../composables/useValidation';
import useHttpRequest from '../../composables/useHttpRequest';
import useModalToast from '../../composables/useModalToast';

import * as yup from 'yup';

const props = defineProps({
    show: {
        type: Boolean,
        default: () => false,
    },
    role: {
        type: [Object, null],
        default: () => null,
    },
});
const emit = defineEmits(['hide']);

const userStore = useUserStore();
const roleStore = useRoleStore();
const permissionStore = usePermissionStore();

const {
    store: createRole,
    saving,
    update: updateRole,
    updating,
} = useHttpRequest('/roles');
const { runYupValidation } = useValidation();
const { showToast } = useModalToast();

const requiredPermissions = computed(() => {
    if (!props.role?.id) return ['roles-all', 'roles-create'];
    else return ['roles-all', 'roles-edit'];
});

const title = computed(() =>
    props.role ? `Update role "${props.role?.name}"` : 'Add new role',
);

const initialFormData = () => {
    return {
        name: null,
        permissions: [],
    };
};

const formData = ref(initialFormData());
const formErrors = ref({});

watch(
    () => props.show,
    () => {
        if (props.show) {
            if (props.role?.id) {
                formData.value = Object.entries(initialFormData()).reduce(
                    (r, [key, val]) => {
                        if (props.role[key])
                            return { ...r, [key]: props.role[key] };
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

const permissionOptions = computed(() => {
    const formDataPermissionIds = formData.value.permissions.map((permission) =>
        permission?.id?.toString(),
    );
    return permissionStore.permissions.filter(
        (permission) =>
            !formDataPermissionIds.includes(permission?.id?.toString()),
    );
});

const selectedPermission = ref(null);
const onPermissionSelect = (permission) => {
    formData.value = {
        ...formData.value,
        permissions: [permission].concat(formData.value.permissions),
    };
    selectedPermission.value = null;
};
const onPermissionRemove = (permission) => {
    const updatedPermissions = formData.value.permissions.filter(
        (fp) => fp?.id?.toString() !== permission?.id?.toString(),
    );

    formData.value = {
        ...formData.value,
        permissions: updatedPermissions,
    };
};

const canShowAddAllPermissions = computed(() =>
    Boolean(
        formData.value.permissions.length !==
            permissionStore.permissions.length,
    ),
);
const onAddAllPermissions = () => {
    formData.value = {
        ...formData.value,
        permissions: permissionStore.permissions,
    };
};

const schema = yup.object().shape({
    name: yup.string().nullable().required(),
});

const onSubmit = async () => {
    if (saving.value || updating.value) return;

    let data = {
        ...formData.value,
        permissions: formData.value.permissions
            ?.map((permission) => permission?.id)
            ?.sort((a, b) => Number(a) - Number(b)),
    };

    const { validated, errors } = await runYupValidation(schema, data);
    if (!validated) {
        formErrors.value = errors;
        return;
    }
    formErrors.value = {};

    const response = props.role?.id
        ? await updateRole(props.role?.id, data)
        : await createRole(data);

    if (response?.id) {
        showToast(
            `Role ${props.role?.id ? 'updated' : 'created'} successfully`,
        );
        roleStore.loadRoles();
        userStore.loadUsers();
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

                <FormLabelError label="Add permission">
                    <VSelect
                        v-model="selectedPermission"
                        :options="permissionOptions"
                        label="name"
                        @update:model-value="
                            (permission) => onPermissionSelect(permission)
                        "
                    />
                </FormLabelError>

                <div class="w-full space-y-3">
                    <div class="flex-between gap-4">
                        <label class="text-sm font-semibold"
                            >Role permissions</label
                        >

                        <div
                            v-if="canShowAddAllPermissions"
                            class="text-xs font-bold cursor-pointer hover:underline w-max-content text-sky-500"
                            @click="onAddAllPermissions"
                        >
                            add all permissions
                        </div>
                    </div>

                    <TransitionGroup
                        tag="ul"
                        name="edit-list"
                        class="relative space-y-3"
                    >
                        <li
                            v-for="permission in formData.permissions"
                            :key="permission.id"
                            class="shadow-google rounded-sm"
                        >
                            <div
                                class="p-4 flex-between w-full dark:bg-gray-800/60 rounded-sm border border-[#e6e6e6] dark:border-gray-700"
                            >
                                <div class="flex-1">{{ permission.name }}</div>
                                <span
                                    class="text-sm cursor-pointer text-red-500 dark:text-red-300"
                                    @click="onPermissionRemove(permission)"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        width="24"
                                        height="24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="css-i6dzq1"
                                    >
                                        <line
                                            x1="18"
                                            y1="6"
                                            x2="6"
                                            y2="18"
                                        ></line>
                                        <line
                                            x1="6"
                                            y1="6"
                                            x2="18"
                                            y2="18"
                                        ></line>
                                    </svg>
                                </span>
                            </div>
                        </li>

                        <Button
                            :title="role?.id ? 'Save' : 'Update'"
                            :loading-title="
                                role?.id ? 'Saving...' : 'Updating...'
                            "
                            class="!w-full"
                            :loading="saving || updating"
                            key="submit-btn"
                            @click="onSubmit"
                        />
                    </TransitionGroup>
                </div>
            </div>
        </AuthorizationFallback>
    </Slider>
</template>

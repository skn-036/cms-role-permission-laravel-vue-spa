<script setup>
import Table from '../components/table/Table.vue';
import THead from '../components/table/THead.vue';
import TBody from '../components/table/TBody.vue';
import Tr from '../components/table/Tr.vue';
import Th from '../components/table/Th.vue';
import Td from '../components/table/Td.vue';
import CreateButton from '../components/ui/CreateButton.vue';
import EditButton from '../components/ui/EditButton.vue';
import DeleteButton from '../components/ui/DeleteButton.vue';
import AuthorizationFallback from '../components/page/AuthorizationFallback.vue';
import PermissionSlider from '../components/page/PermissionSlider.vue';

import useUserStore from '../store/useUserStore';
import useRoleStore from '../store/useRoleStore';
import usePermissionStore from '../store/usePermissionStore';

import useSlider from '../composables/useSlider';
import useModalToast from '../composables/useModalToast';
import useHttpRequest from '../composables/useHttpRequest';
import useAuth from '../composables/useAuth';

const userStore = useUserStore();
const roleStore = useRoleStore();
const permissionStore = usePermissionStore();

if (!permissionStore.permissions.length)
    await permissionStore.loadPermissions();

const { slider, sliderData, showSlider, hideSlider } =
    useSlider('permission-crud');
const { showConfirmModal, showToast } = useModalToast();
const { destroy: deletePermission, deleting } = useHttpRequest('/permissions');
const { isUserAuthenticated } = useAuth();

const onDelete = (permission) => {
    if (deleting.value) return;

    showConfirmModal(null, async (confirmed) => {
        if (!confirmed) return;

        const isDeleted = await deletePermission(permission?.id);
        if (isDeleted) {
            showToast(
                `Permission "${permission?.name}" deleted successfully...`,
            );
            permissionStore.loadPermissions();
            userStore.loadUsers();
            roleStore.loadRoles();
            isUserAuthenticated();
        }
    });
};
</script>

<template>
    <AuthorizationFallback
        :permissions="['permissions-all', 'permissions-view']"
    >
        <div class="w-full space-y-4 py-6">
            <div class="flex-between">
                <h2 class="text-active font-bold text-2xl">Permissions</h2>

                <CreateButton @click="showSlider(true)" />
            </div>

            <div class="w-full">
                <Table>
                    <THead>
                        <Tr>
                            <Th> Id </Th>
                            <Th> Permission </Th>
                            <Th> Action </Th>
                        </Tr>
                    </THead>

                    <TBody>
                        <Tr
                            v-for="permission in permissionStore.permissions"
                            :key="permission.id"
                        >
                            <Td>{{ permission?.id }}</Td>
                            <Td>
                                <div
                                    class="text-emerald-500 dark:text-emerald-200"
                                >
                                    {{ permission?.name }}
                                </div>
                            </Td>

                            <Td class="align-middle">
                                <div class="flex flex-col gap-2">
                                    <EditButton
                                        @click="showSlider(true, permission)"
                                    />
                                    <DeleteButton
                                        @click="onDelete(permission)"
                                    />
                                </div>
                            </Td>
                        </Tr>
                    </TBody>
                </Table>
            </div>
        </div>

        <PermissionSlider
            :show="slider"
            :permission="sliderData"
            @hide="hideSlider"
        />
    </AuthorizationFallback>
</template>

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
import UserSlider from '../components/page/UserSlider.vue';

import useUserStore from '../store/useUserStore';
import useRoleStore from '../store/useRoleStore';
import useSlider from '../composables/useSlider';
import useModalToast from '../composables/useModalToast';
import useHttpRequest from '../composables/useHttpRequest';

const userStore = useUserStore();
const roleStore = useRoleStore();

if (!userStore.users?.length) await userStore.loadUsers();
if (!roleStore.roles?.length) await roleStore.loadRoles();

const { slider, sliderData, showSlider, hideSlider } = useSlider('user-crud');
const { showConfirmModal, showToast } = useModalToast();
const { destroy: deleteUser, deleting } = useHttpRequest('/users');

const onDelete = (user) => {
    if (deleting.value) return;

    showConfirmModal(null, async (confirmed) => {
        if (!confirmed) return;

        const isDeleted = await deleteUser(user?.id);
        if (isDeleted) {
            showToast(`"${user?.name}" deleted successfully...`);
            userStore.loadUsers();
        }
    });
};
</script>

<template>
    <AuthorizationFallback :permissions="['users-all', 'users-view']">
        <div class="w-full space-y-4 py-6">
            <div class="flex-between">
                <h2 class="text-active font-bold text-2xl">Users</h2>

                <CreateButton @click="showSlider(true)" />
            </div>

            <div class="w-full">
                <Table>
                    <THead>
                        <Tr>
                            <Th> Id </Th>
                            <Th> User </Th>
                            <Th> Roles </Th>
                            <Th> Permissions </Th>
                            <Th> Action </Th>
                        </Tr>
                    </THead>

                    <TBody>
                        <Tr
                            v-for="user in userStore.users"
                            :key="user.id"
                        >
                            <Td>{{ user?.id }}</Td>
                            <Td>
                                <div
                                    class="text-emerald-500 dark:text-emerald-200"
                                >
                                    {{ user?.name }}
                                </div>
                                <div class="text-xsm text-[#aaa]">
                                    {{ user?.email }}
                                </div>
                            </Td>
                            <Td>
                                <ul class="w-max mx-auto list-disc">
                                    <li
                                        v-for="role in user.roles"
                                        :key="role.id"
                                        class="text-left"
                                    >
                                        {{ role?.name }}
                                    </li>
                                </ul>
                            </Td>
                            <Td>
                                <ul class="w-max mx-auto list-disc">
                                    <li
                                        v-for="permission in user.permissions"
                                        :key="permission.id"
                                        class="text-left"
                                    >
                                        {{ permission?.name }}
                                    </li>
                                </ul>
                            </Td>
                            <Td class="align-middle">
                                <div class="flex flex-col gap-2">
                                    <EditButton
                                        @click="showSlider(true, user)"
                                    />
                                    <DeleteButton @click="onDelete(user)" />
                                </div>
                            </Td>
                        </Tr>
                    </TBody>
                </Table>
            </div>
        </div>

        <UserSlider
            :show="slider"
            :user="sliderData"
            @hide="hideSlider"
        />
    </AuthorizationFallback>
</template>

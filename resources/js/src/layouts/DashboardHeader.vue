<script setup>
import { inject } from 'vue';
import useHttpRequest from '../composables/useHttpRequest';
import useUserStore from '../store/useUserStore';
import useRoleStore from '../store/useRoleStore';
import usePermissionStore from '../store/usePermissionStore';
import useAppRouter from '../composables/useAppRouter';

const { isDarkMode, updateDarkMode, windowWidth } = inject('theme');

const { index: logout } = useHttpRequest('/logout');
const { pushToRoute } = useAppRouter();

const userStore = useUserStore();
const roleStore = useRoleStore();
const permissionStore = usePermissionStore();

const onLogout = async () => {
    const isLoggedOut = await logout();
    if (isLoggedOut) {
        userStore.setUser(null);
        userStore.users = [];
        roleStore.roles = [];
        permissionStore.permissions = [];

        await pushToRoute({ name: 'login' });
    }
};
</script>

<template>
    <div>
        <!-- logo -->
        <RouterLink :to="{ name: 'users' }">
            <div class="text-3xl font-nabla hidden md:block">
                <span class="logo-char animation-delay-100">R</span>
                <span class="logo-char animation-delay-200">o</span>
                <span class="logo-char animation-delay-300">l</span>
                <span class="logo-char animation-delay-400">e</span>
                <span class="">{{ ' ' }}</span>
                <span class="logo-char animation-delay-500">P</span>
                <span class="logo-char animation-delay-600">e</span>
                <span class="logo-char animation-delay-700">r</span>
                <span class="logo-char animation-delay-800">m</span>
                <span class="logo-char animation-delay-900">i</span>
                <span class="logo-char animation-delay-1000">s</span>
                <span class="logo-char animation-delay-1100">s</span>
                <span class="logo-char animation-delay-1200">i</span>
                <span class="logo-char animation-delay-1300">o</span>
                <span class="logo-char animation-delay-1400">n</span>
                <span class="logo-char animation-delay-1500">s</span>
            </div>
            <div class="text-2xl font-nabla md:hidden">
                <span class="logo-char animation-delay-100">R</span>
                <span class="">{{ ' ' }}</span>
                <span class="logo-char animation-delay-200">P</span>
            </div>
        </RouterLink>

        <!-- menu links -->

        <div class="flex-start gap-4 lg:gap-8">
            <div class="flex flex-col gap-0.5">
                <div class="flex-start gap-6 lg:gap-8">
                    <RouterLink :to="{ name: 'users' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                                >Users</span
                            >
                        </template>
                    </RouterLink>

                    <RouterLink :to="{ name: 'roles' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                                >Roles</span
                            >
                        </template>
                    </RouterLink>

                    <RouterLink :to="{ name: 'permissions' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                                >Permissions</span
                            >
                        </template>
                    </RouterLink>

                    <span
                        class="lg:text-lg font-bold hover:text-active-hover cursor-pointer text-red-200"
                        @click="onLogout"
                    >
                        Logout
                    </span>
                </div>

                <div
                    v-if="userStore.user?.id"
                    class="text-xs text-emerald-300 flex justify-end"
                >
                    {{ `${userStore.user?.name} (${userStore.user?.email})` }}
                </div>
            </div>

            <!-- sun -->
            <span
                v-if="isDarkMode"
                class="hover:text-active-hover cursor-pointer"
                @click="updateDarkMode(false)"
            >
                <svg
                    viewBox="0 0 24 24"
                    :width="windowWidth > 992 ? 24 : 18"
                    :height="windowWidth > 992 ? 24 : 18"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="css-i6dzq1"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="5"
                    ></circle>
                    <line
                        x1="12"
                        y1="1"
                        x2="12"
                        y2="3"
                    ></line>
                    <line
                        x1="12"
                        y1="21"
                        x2="12"
                        y2="23"
                    ></line>
                    <line
                        x1="4.22"
                        y1="4.22"
                        x2="5.64"
                        y2="5.64"
                    ></line>
                    <line
                        x1="18.36"
                        y1="18.36"
                        x2="19.78"
                        y2="19.78"
                    ></line>
                    <line
                        x1="1"
                        y1="12"
                        x2="3"
                        y2="12"
                    ></line>
                    <line
                        x1="21"
                        y1="12"
                        x2="23"
                        y2="12"
                    ></line>
                    <line
                        x1="4.22"
                        y1="19.78"
                        x2="5.64"
                        y2="18.36"
                    ></line>
                    <line
                        x1="18.36"
                        y1="5.64"
                        x2="19.78"
                        y2="4.22"
                    ></line>
                </svg>
            </span>

            <span
                v-else
                class="hover:text-active-hover cursor-pointer"
                @click="updateDarkMode(true)"
            >
                <svg
                    viewBox="0 0 24 24"
                    :width="windowWidth > 992 ? 24 : 18"
                    :height="windowWidth > 992 ? 24 : 18"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="css-i6dzq1"
                >
                    <path
                        d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                    ></path>
                </svg>
            </span>
        </div>
    </div>
</template>
../store/useAuthUserStore

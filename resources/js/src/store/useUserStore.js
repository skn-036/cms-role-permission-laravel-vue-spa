import { ref } from 'vue';
import { defineStore } from 'pinia';

import useHttpRequest from '../composables/useHttpRequest';

const useUserStore = defineStore('users', () => {
    const {
        index: getUsers,
        loading: usersLoading,
        initialLoading: usersFirstTimeLoading,
    } = useHttpRequest('/users');

    const user = ref(null);
    const users = ref([]);

    const setUser = (authUser) => {
        user.value = authUser;
    };

    const loadUsers = async () => {
        const response = await getUsers();
        users.value = response;
    };

    return {
        user,
        setUser,
        users,
        usersLoading,
        usersFirstTimeLoading,
        loadUsers,
    };
});

export default useUserStore;

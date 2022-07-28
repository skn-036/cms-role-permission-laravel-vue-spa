import axios from 'axios';

const state = {
    roles: {},
    role: {},
    newRolePage: {},
    message: {},
    editItems: {},
    loadingState: false,
};

const getters = {
    roles: state => state.roles,
    role: state => state.role,
    createRolePage: state => state.newRolePage,
    retrieveMessage: state => state.message,
    editRoleInputs: state => state.editItems,
    loading: state => state.loadingState,
};

const actions = {
    getRoles({ commit }) {
        commit('loadingStatus', true);
        axios
            .get('/api/admin/roles')
            .then(response => {
                if (response.status == 200) {
                    commit('roles', response.data);
                    commit('loadingStatus', false);
                }
            })
            .catch(error => {
                console.log(error);
            });
    },

    viewRole({ commit }, id) {
        commit('loadingStatus', true);
        axios
            .get('/api/admin/roles/' + id)
            .then(response => {
                if (response.status == 200) {
                    commit('role', response.data);
                    commit('loadingStatus', false);
                }
            })
            .catch(error => {
                console.log(error);
            });
    },

    createRole({ commit }) {
        commit('loadingStatus', true);
        axios
            .get('/api/admin/roles/create')
            .then(response => {
                commit('createNewRolePage', response.data);
                commit('loadingStatus', false);
            })
            .catch(error => {
                console.log(error);
            });
    },

    storeNewRole({ commit }, input) {
        axios
            .post('/api/admin/roles', {
                newRole: input,
            })
            .then(response => {
                if (response.status == 200) {
                    commit('message', response.data);
                }
            })
            .catch(error => {
                console.log(error);
            });
    },

    editRole({ commit }, routeId) {
        commit('loadingStatus', true);
        axios
            .get('/api/admin/roles/' + routeId + '/edit')
            .then(response => {
                commit('edit', response.data);
                commit('loadingStatus', false);
            })
            .catch(error => {
                console.log(error);
            });
    },

    updateRole({ commit }, perm) {
        axios
            .put('/api/admin/roles/' + perm.roleId, {
                data: perm,
            })
            .then(response => {
                commit('message', response.data);
            })
            .catch(error => {
                console.log(error);
            });
    },

    deleteRole({ commit }, routeId) {
        axios.delete('/api/admin/roles/' + routeId).then(response => {
            if (response.status == 200) {
                commit('message', response.data);
            }
        });
    },
};

const mutations = {
    roles: (state, payload) => (state.roles = payload),
    role: (state, payload) => (state.role = payload),
    createNewRolePage: (state, payload) => (state.newRolePage = payload),
    message: (state, payload) => (state.message = payload),
    edit: (state, payload) => (state.editItems = payload),
    loadingStatus: (state, payload) => (state.loadingState = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};

import Router from '../../Router'

const state = {
    loginResponse : {},
    authUser : {},
}

const getters = {
    getLoginResponse : state => state.loginResponse,
    getAuthUser : state => state.authUser,
}

const actions = {
    login({commit, getters }, loginData) {
        axios.get('/sanctum/csrf-cookie')
        .then(() => {
            axios.post('/api/login', {
                "email" : loginData.email,
                "password" : loginData.password
            })
            .then(response => {
                commit('mutateLoginResponse', response.data)
                sessionStorage.setItem('loginResponse', JSON.stringify(response.data))               
                if(getters.getLoginResponse.response_type == 'success') {
                    axios.get('/api/user')
                    .then(response => {
                        if(response.status == 200) {
                            commit('mutateAuthUser', response.data)
                            sessionStorage.setItem('authUser', JSON.stringify(response.data))
                            Router.push('/admin')
                        }                    
                    })
                }
            })
        })          
    },

    logout() {
        axios.get('/api/logout')
        .then(() => {
            sessionStorage.removeItem('loginResponse')
            sessionStorage.removeItem('authUser')
            Router.push('/')
        })
    }
}

const mutations = {
    mutateLoginResponse : (state, payload) => state.loginResponse = payload,  
    mutateAuthUser : (state, payload) => state.authUser = payload,
}

export default {
    state, getters, actions, mutations
}
import Vue from 'vue'
import Vuex from 'vuex'
import Roles from './Modules/roles'
import Permissions from './Modules/permissions'
import Login from './Modules/login'

Vue.use(Vuex)

const Store = new Vuex.Store({
    modules : {
        Roles,
        Permissions,
        Login,
    }
})

export default Store
<template>
    <div v-if="$route.path == '/'">
        <log-in />
    </div>

    <div class="container-fluid mt-4" v-else-if="loginResponse.authenticated && authUser.role_type == 'administrator'">
        <div class="row">
            <div class="col-md-2">
                <sidebar />
            </div>
            <div class="col-md-10" >
                <div class="row mt-2 mb-4 border-bottom-999 d-flex justify-content-between align-items-center mx-2">
                    <h4 v-if="authUser">Welcome {{ authUser.name }}</h4>
                    <button class="btn btn-danger mb-2" @click="logout">Logout</button>
                </div>

                <router-view />
            </div>
        </div>
    </div>

    <div style="" class="d-flex unauthorized" v-else-if="loginResponse.authenticated && authUser.role_type !== 'administrator'">
        <button class="btn btn-danger mb-2" @click="logout">Logout</button>
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">Users are not authorized to access CMS panel. Go back and log in with administrative account to proceed futher</h5>
        </div>
    </div>

    <div style="" class="d-flex unauthorized" v-else>
        <button class="btn btn-link text-right" @click="back();">Back</button>
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
        </div>
    </div>
</template>

<script>

    import Sidebar from './sidebar'
    import LogIn from './login'
    import { mapActions} from 'vuex'

    export default {
        components : {
            Sidebar,
            LogIn
        },

        methods : {
            ...mapActions(['logout']),

            back() {
                this.$router.push('/')
            },
        },

        computed : {

            loginResponse() {
                let output = undefined;

                if(this.$store.getters.getLoginResponse.authenticated !== undefined && output == undefined) {
                   output = this.$store.getters.getLoginResponse 
                }

                if(JSON.parse(sessionStorage.getItem('loginResponse')) !== undefined && output == undefined) {
                    output = JSON.parse(sessionStorage.getItem('loginResponse'))
                }

                if(output == undefined) {
                    output = {
                        'authenticated' : false
                    }
                }
                return output
            },

            authUser() {
                if(this.$store.getters.getAuthUser.id !== undefined) {
                    return this.$store.getters.getAuthUser
                }
                return JSON.parse(sessionStorage.getItem('authUser'))              
            }
        },
    }
</script>
<template>
    <section id="login-container">
        <div class="login">
            <h3 class="text-center my-2">Login</h3>
            <div class="form-group d-flex flex-column m-3">
                <label for="email" class="font-bold">Email:</label>
                <input type="text" id="email" 
                :class="[(loginResponse.response_type == 'error') ? 'error' : '', 'form-control']" 
                v-model="loginData.email">
                <div v-if="loginResponse">
                    <div class="text-danger" v-if="loginResponse.response_type == 'error'"
                    v-for="(error, index) in loginResponse.response_data">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="form-group d-flex flex-column m-3 password-group">
                <label for="password" class="font-bold">Password:</label>
                <input type="password" id="password" 
               :class="[(loginResponse.response_type == 'error') ? 'error' : '', 'form-control']"
                v-model="loginData.password">
                <span @click="showPassword();">
                    <font-awesome-icon :icon="['fa', 'eye']" />
                </span>
            </div>
            <button class="btn btn-primary m-3" @click="loginSubmit();">Submit</button>
        </div>
    </section>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex'
 
    export default {
        data() {
            return {
                loginData : {
                    email : '',
                    password : '',
                },
            }
        },

        methods : {
            ...mapActions(['login']),

            loginSubmit() {
                this.login(this.loginData)
                //this.loginData.password = ''
            },

            showPassword() {
                let password = document.querySelector('#password')
                if(password.type == 'password') {
                    password.type = 'text'
                }
                else {
                    password.type = 'password'
                }
            },
        },

        computed : {
            ...mapGetters({
                loginResponse : 'getLoginResponse',
            }),
        },
    }
</script>
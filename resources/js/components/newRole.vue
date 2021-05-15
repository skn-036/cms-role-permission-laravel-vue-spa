<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="createRolePage.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ createRolePage.message }}</h5>
        </div>
    </div>
    <section id="new-product" v-else>
        <h3 class="my-3">New Role:</h3>
        <div class="row d-flex flex-row text-center">
            <input type="text" class="w-50 mr-2 ml-3 border-radius-5px" v-model="newRole">
            <router-link :to="{ name: 'roles' }" 
            class="btn btn-primary"
            @click.native="changeActive(); storeNewRole(newRole); getRoles()">
                Submit
            </router-link>
        </div>

        <router-link 
        :to="{ name : 'roles' }"
        @click.native="changeActive();"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>

    import {mapActions, mapGetters} from 'vuex'

    export default {
        data() {
            return {
                newRole : '',
            }
        },

        methods : {

            ...mapActions(['storeNewRole', 'getRoles', 'createRole']),

            changeActive() {
                let links = document.querySelectorAll('#sidebar ul li')

                links.forEach(change)
                function change(item) {
                    item.classList.remove("active");
                }
                    
                document.querySelector('#nav-3').classList.add("active")
            },
        },

        created() {
            this.createRole()
        },

        computed : {
            ...mapGetters(['createRolePage', 'loading'])
        }
    }
</script>
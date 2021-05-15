<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="newPermPage.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ newPermPage.message }}</h5>
        </div>
    </div>
    <section id="new-product" v-else>
        <h3 class="my-3">New Permission:</h3>
        <div class="row d-flex flex-row text-center">
            <input type="text" class="w-50 ml-3 mr-2 border-radius-5px" v-model="newPermission">
            <router-link :to="{ name: 'permissions' }" 
            class="btn btn-primary"
            @click.native="changeActive(); storeNewPermission(newPermission); getPermissions();">
                Submit
            </router-link>
        </div>

        <router-link 
        :to="{ name : 'permissions' }"
        @click.native="changeActive()"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>

    import { mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                newPermission : '',
            }
        },

        methods : {

            ...mapActions(['storeNewPermission', 'getPermissions', 'createPermission']),

            changeActive() {
                let links = document.querySelectorAll('#sidebar ul li')

                links.forEach(change)
                function change(item) {
                    item.classList.remove("active");
                }
                    
                document.querySelector('#nav-5').classList.add("active")
            },
        },

        computed : {
            ...mapGetters(['newPermPage', 'loading'])
        },

        created() {
            this.createPermission()
        }
    }
</script>
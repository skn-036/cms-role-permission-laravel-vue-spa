<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="editPerm.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ editPerm.message }}</h5>
        </div>
    </div>

    <section id="edit-permission" v-else>
        <h3 class="my-3">Edit Permission:</h3>
        <div class="row d-flex flex-row text-center">
            <input id="edit-permission" type="text" class="w-50 ml-3 mr-2 border-radius-5px" :placeholder="editPerm.permission.name" v-model="editData">
            <router-link 
            :to="{ name : 'permissions' }"
            @click.native="submit(); getPermissions();"
            class="btn btn-primary">Submit
            </router-link>
        </div>

        <router-link 
        :to="{ name : 'permissions' }"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {

        methods : {
            ...mapActions(['editPermission', 'updatePermission', 'getPermissions']),

            submit() {
                if(this.editData == '') {
                    this.editData = this.editPerm.permission.name
                }
                
                let data = {}
                data['update'] = this.editData
                data['id'] = this.editPerm.permission.id
                this.updatePermission(data)
            }
        },

        created() {
            this.editPermission(this.$route.params.id)
        },

        computed : {
            ...mapGetters(['editPerm', 'loading'])
        },

        data() {
            return {
                editData : ''
            }
        },
    }
</script>

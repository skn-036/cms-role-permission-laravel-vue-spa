<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="editRoleInputs.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ editRoleInputs.message }}</h5>
        </div>
    </div>

    <section id="new-product" v-else>
        <h3 class="mt-3">Edit {{ editRoleInputs.role.name }} Role</h3>

        <h5 class="my-3 text-success">Add Permission:</h5>

        <div class="row d-flex flex-row text-center">
            <select class="w-50 mx-3 border-radius-5px" v-model="permId" multiple>
                <option 
                v-for="(perm, index) in editRoleInputs.not_granted_permissions" :key="index"
                :value="perm.id"> {{ perm.name }}
                </option>
            </select>

            <router-link :to="{ name : 'roles' }"
            @click.native="update(type = 'Added'); getRoles();" 
            class="btn btn-success my-auto">
                Add
            </router-link>
        </div>

        <h5 class="my-3 text-danger">Remove Permission:</h5>
        <div class="row d-flex flex-row text-center">
            <select class="w-50 mx-3 border-radius-5px" v-model="permId" multiple>
                <option 
                v-for="(perm, index) in editRoleInputs.granted_permissions" :key="index"
                :value="perm.id"> {{ perm.name }}
                </option>
            </select>
            <router-link :to="{ name : 'roles' }"
            @click.native="update(type = 'Removed'); getRoles();" 
            class="btn btn-danger my-auto">
                Remove
            </router-link>
        </div>

        <router-link :to="{ name : 'roles' }" class="btn btn-warning my-3">Back</router-link>

    </section>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {

        data : function() {
            return {
                permId : [],
            }
        },

        methods : {
            ...mapActions(['editRole', 'updateRole', 'getRoles']),

            update(type) {
                let data = {};
                data['type'] = type
                data['roleId'] = this.editRoleInputs.role.id
                data['permIds'] = this.permId
                this.updateRole(data)
            }
        },

        created() {
            this.editRole(this.$route.params.id)
        },

        computed : {
            ...mapGetters(['editRoleInputs', 'loading'])
        }
    }
</script>
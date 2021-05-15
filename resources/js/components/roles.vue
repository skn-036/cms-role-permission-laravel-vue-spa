<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="roles.viewAll_index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ roles.message }}</h5>
        </div>
    </div>

    <section id="all-roles" class="view-table" v-else>
        <h3 class="mb-3">All Roles</h3>
        <div v-if="retrieveMessage.response_index" class="text-center">
            <h6 v-for="(message, index) in retrieveMessage.response_message" :key="index"
            :class="[(retrieveMessage.response_type == 'Error') ? 'text-danger' : 'text-success', 'font-20', 'my-3']">
                *** {{ retrieveMessage.response_type + ': ' + message }} ***
            </h6>
        </div>
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Assigned Permissions</th>
                    <th>Query</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(role, index) in roles.data" :key="index">
                    <td> {{ index + 1 }} </td>
                    <td> {{ role.name }}</td>
                    <td>
                        <ol>
                            <li  v-for="(perm, index) in role.permissions">{{ perm.name }}</li>
                        </ol>
                    </td>
                    <td class="d-flex flex-row justify-content-center">
                        <router-link :to="{ name : 'viewRole' , params: { id: role.id }}"
                        @click.native="viewRole($route.params.id)"
                        class="bg-primary text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="roles.view_index !== false">
                            <font-awesome-icon :icon="['fa', 'eye']" />
                        </router-link>
                        <router-link :to="{ name : 'editRole' , params: { id: role.id }}" 
                        class="bg-success text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="roles.edit_index !== false">
                            <font-awesome-icon :icon="['fa', 'edit']" />
                        </router-link>
                        <button
                        @click="deleteRole(role.id); getRoles();"
                        class="bg-danger text-white p-1 cursor-pointer border-radius-5px border-none"
                        v-if="roles.delete_index !== false">
                            <font-awesome-icon :icon="['fa', 'trash-alt']" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {

        methods : {
            ...mapActions(['getRoles', 'viewRole', 'deleteRole']),

        },

        computed : {
            ...mapGetters(['retrieveMessage', 'roles', 'loading']),
        },

        created() {
            this.getRoles();
        },
    }
</script>
<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="permissions.viewAll_index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ permissions.message }}</h5>
        </div>
    </div>

    <section id="all-permissions" class="view-table" v-else>
        <h3 class="mb-3">All Permissions</h3>
        <div v-if="retrieveMessage2.response_index" class="text-center">
            <h6 v-for="(message, index) in retrieveMessage2.response_message" :key="index"
            :class="[(retrieveMessage2.response_type == 'Error') ? 'text-danger' : 'text-success', 'font-20', 'my-3']">
                *** {{ retrieveMessage2.response_type + ': ' + message }} ***
            </h6>
        </div>
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Permission Name</th>
                    <th>Assigned To Roles</th>
                    <th>Query</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(permission, index) in permissions.data.data" :key="index">
                    <td> {{ ((permissions.data.current_page - 1) * 8) + index + 1 }}</td>
                    <td>{{ permission.name }}</td>
                    <td>
                        <ol>
                            <li v-for="(role, index) in permission.roles"> {{ role.name }}</li>
                        </ol>
                    </td>
                    <td class="d-flex flex-row justify-content-center">
                        <router-link :to="{ name : 'viewPermission' , params: { id: permission.id }}"
                        @click.native="viewPermission($route.params.id);"
                        class="bg-primary text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="permissions.view_index !== false">
                            <font-awesome-icon :icon="['fa', 'eye']" />
                        </router-link>
                        <router-link :to="{ name : 'editPermission' , params: { id: permission.id }}"
                        @click.native="editPermission($route.params.id);"
                        class="bg-success text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="permissions.edit_index !== false">
                            <font-awesome-icon :icon="['fa', 'edit']" />
                        </router-link>
                        <button
                        @click="deletePermission(permission.id); getPermissions();"
                        class="bg-danger text-white p-1 cursor-pointer border-radius-5px border-none"
                        v-if="permissions.delete_index !== false">
                            <font-awesome-icon :icon="['fa', 'trash-alt']" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <pagination 
            :data="permissions.data"
            @pagination-change-page="getPermissions"
            :limit="1"
            align="center"
            :show-disabled="true"
            />
        </div>
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import pagination from 'laravel-vue-pagination'

    export default {

        components: {
            pagination
        },

        methods : {
            ...mapActions(['getPermissions', 'viewPermission', 'editPermission', 'deletePermission'])
        },

        computed : {
            ...mapGetters(['retrieveMessage2', 'permissions', 'loading']),
        },

        created() {
            this.getPermissions();
        },
    }
</script>
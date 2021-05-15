<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="permission.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ permission.message }}</h5>
        </div>
    </div>

    <section id="view-permission" v-else>
        <h3 class="my-3">View Permission:</h3>

        <div class="d-flex flex-row mr-2">
            <h5 class="mr-2"><strong>Permission Name: </strong></h5>
            <h5>{{ permission.data.name }}</h5>
        </div>

        <h5 class="mt-4"><strong>Assigned To Roles: </strong></h5>
        <ol>
            <li v-for="(role, index) in permission.data.roles">{{ role.name }}</li>
        </ol>

        <router-link 
        :to="{ name : 'permissions' }"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        methods : {
            ...mapActions(['viewPermission'])
        },

        computed : {
            ...mapGetters(['permission', 'loading'])
        },

        created() {
            this.viewPermission(this.$route.params.id)
        }
    }
</script>
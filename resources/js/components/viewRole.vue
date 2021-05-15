<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div style="" class="d-flex no-auth" v-else-if="role.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ role.message }}</h5>
        </div>
    </div>

    <section id="view-role" v-else>
        <h3 class="my-3">View Role:</h3>

        <div class="d-flex flex-row mr-2">
            <h5 class="mr-2 vertical-baseline"><strong> Role Name: </strong></h5>
            <h5 class="vertical-baseline"> {{ role.data.name }}</h5>
        </div>

        <h5 class="mt-4"><strong>Granted Permissions: </strong></h5>
        <ol>
            <li v-for="(perm, index) in role.data.permissions" :key="index"> {{ perm.name }} </li>
        </ol>

        <router-link 
        :to="{ name : 'roles' }"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        methods : {
            ...mapActions(['viewRole'])
        },

        computed : {
            ...mapGetters(['role', 'loading'])
        },

        created() {
            this.viewRole(this.$route.params.id)
        }
    }
</script>
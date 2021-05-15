<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div class="d-flex no-auth" v-else-if="product.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ product.message }}</h5>
        </div>
    </div>

    <section id="edit-product" v-else>
        <h3 class="my-3">Edit Product</h3>
        <h4 class="text-danger">Form Element for Update Product goes here ....</h4>

        <router-link :to="{ name : 'products' }" class="btn btn-warning my-3">Back</router-link>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                product : {},
                loading : false
            }
        },

        methods : {
            editProduct(id) {
                this.loading = true
                axios.get('/api/admin/products/' + id + '/edit')
                .then(response => {
                    this.product = response.data
                    this.loading = false
                })
                .catch(error => {
                    console.log(error)
                }) 
            }
        },

        created() {
            this.editProduct(this.$route.params.id)
        }
    }
</script>
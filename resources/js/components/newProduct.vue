<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div class="no-auth d-flex" v-else-if="product.index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ product.message }}</h5>
        </div>
    </div>

    <section id="new-product" v-else>
        <h3 class="my-3">New Product</h3>
        <h4 class="text-danger">Form Element for creating new product goes here ....</h4>

        <router-link :to="{ name : 'products' }"
        @click.native="changeActive()" 
        class="btn btn-warning my-3">Back
        </router-link>
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
            changeActive() {
                let links = document.querySelectorAll('#sidebar ul li')

                links.forEach(change)
                function change(item) {
                    item.classList.remove("active");
                }
                    
                document.querySelector('#nav-1').classList.add("active")
            },

            createProduct() {
                this.loading = true
                axios.get('/api/admin/products/create')
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
            this.createProduct()
        }
    }
</script>
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

    <section id="view-product" v-else>
        <h3 class="my-3">View Product:</h3>

        <h5 class="mb-2"><strong>Product Id: </strong> {{ product.data.id }} </h5>
        <h5 class="mb-2"><strong>Product Brand: </strong> {{ product.data.brand }} </h5>
        <h5 class="mb-2"><strong>Product Model: </strong> {{ product.data.model }} </h5>
        <h5 class="mb-2"><strong>Product Category: </strong> {{ product.data.category }} </h5>
        <h5 class="mb-2"><strong>Product Price: </strong> $ {{ product.data.price }} </h5>
        <h5 class="mb-2"><strong>Product Discount: </strong> {{ product.data.discount }}% </h5>
        <h5 class="mb-2"><strong>Product Discount Price: </strong> $ {{ product.data.discount_price }} </h5>
        <h5 class="mb-2"><strong>Product Rating: </strong> {{ product.data.rating }} </h5>
        
        <router-link 
        :to="{ name : 'products' }"
        class="btn btn-warning my-3">Back
        </router-link>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                product: {},
                loading : false,
            }
        },

        methods: {
            getSingleProduct(id) {
                this.loading = true
                axios.get(`/api/admin/products/${id}`)
                .then(response => {
                    if(response.status == 200) {
                        this.product = response.data
                        this.loading = false
                    }
                })
            }
        },

        created() {
            this.getSingleProduct(this.$route.params.id);
        }
        
    }
</script>
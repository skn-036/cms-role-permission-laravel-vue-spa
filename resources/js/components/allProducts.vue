<template>
    <div class="loader d-flex" v-if="loading">
        <p class="loading m-auto"></p>
    </div>

    <div class="d-flex no-auth" v-else-if="products.viewAll_index == false">
        <div class="d-flex flex-column m-auto">
            <h1 class="text-center">401</h1>
            <h1 class="text-center">UNAUTHORIZED</h1>
            <h5 class="text-center">{{ products.message }}</h5>
        </div>
    </div>

    <section id="all-products" class="view-table" v-else>
        <h3 class="mb-3">All Products</h3>

        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Brand</th>
                    <th>Categ</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Discount Price</th>
                    <th>Rating</th>
                    <th>Query</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products.data.data" :key="index">
                    <td>{{ ((products.data.current_page - 1) * 12 ) + index + 1 }}</td>
                    <td>{{ product.brand }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.model }}</td>
                    <td>$ {{ product.price }}</td>
                    <td>{{ product.discount }}%</td>
                    <td>$ {{ product.discount_price }}</td>
                    <td>{{ product.rating }}</td>
                    <td class="d-flex flex-row justify-content-center">
                        <router-link :to="{ name : 'viewProduct' , params: { id: product.id }}" 
                        class="bg-primary text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="products.view_index !== false">
                            <font-awesome-icon :icon="['fa', 'eye']" />
                        </router-link>
                        <router-link :to="{ name : 'editProduct' , params: { id: product.id }}" 
                        class="bg-success text-white p-1 mr-1 cursor-pointer border-radius-5px"
                        v-if="products.edit_index !== false">
                            <font-awesome-icon :icon="['fa', 'edit']" />
                        </router-link>
                        <router-link :to="{ name : 'deleteProduct', params: { id: product.id }}" 
                        class="bg-danger text-white p-1 cursor-pointer border-radius-5px"
                        v-if="products.delete_index !== false">
                            <font-awesome-icon :icon="['fa', 'trash-alt']" />
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination-container">
            <pagination 
            :data="products.data"
            @pagination-change-page="getProducts"
            :limit="1"
            align="center"
            :show-disabled="true"
            />
        </div>
    </section>
</template>

<script>

    import pagination from 'laravel-vue-pagination'

    export default {
        data() {
            return {
                products : {},
                loading : false,
            }
        },

        components: {
            pagination
        },

        methods : {
            getProducts(page) {
                this.loading = true
                if(typeof page == 'undefined') {
                    page = 1
                }

                axios.get('api/admin?page=' + page)
                .then(response => {
                    if(response.status == 200) {
                        this.products = response.data
                        this.loading = false
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },

        created() {
            this.getProducts()
        }
    }
</script>


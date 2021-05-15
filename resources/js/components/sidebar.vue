<template>
    <div id="sidebar">
        <ul>
            <li id="nav-1"
            :class="[($route.name == 'products' || $route.name == 'allProducts' || $route.name == 'viewProduct' || 
            $route.name == 'editProduct' || $route.name == 'deleteProduct') ? 'active' : '']">
                <router-link :to="{ name : 'products' }" @click.native="changeActive($event)">All Products</router-link>
            </li>

            <li id="nav-2" :class="[($route.name == 'createProducts') ? 'active' : '']">
                <router-link :to="{ name : 'createProducts' }" @click.native="changeActive($event)">Add Product</router-link>
            </li>

            <li id="nav-3" :class="[($route.name == 'roles' || $route.name == 'viewRole' || $route.name == 'editRole') ? 'active' : '']">
                <router-link :to="{ name : 'roles' }" @click.native="changeActive($event)">All Roles</router-link>
            </li>

            <li id="nav-4" :class="[($route.name == 'createRole') ? 'active' : '']">
                <router-link :to="{ name : 'createRole' }" @click.native="changeActive($event)">Add Role</router-link>
            </li>

            <li id="nav-5" :class="[($route.name == 'permissions' || $route.name == 'viewPermission' || $route.name == 'editPermission') 
            ? 'active' : '']">
                <router-link :to="{ name : 'permissions' }" @click.native="changeActive($event)">All Permissions</router-link>
            </li>
            <li id="nav-6" :class="[($route.name == 'createPermission') ? 'active' : '']">
                <router-link :to="{ name : 'createPermission' }" @click.native="changeActive($event)">Add Permission</router-link>
            </li>

        </ul>
    </div>
</template>

<script>

    export default {
        methods : {

            changeActive(event) {
                let links = document.querySelectorAll('#sidebar ul li')

                links.forEach(change)

                function change(item) {
                    item.classList.remove("active");
                }
                    
                event.path[1].classList.add("active")
            },
        },

    }
</script>


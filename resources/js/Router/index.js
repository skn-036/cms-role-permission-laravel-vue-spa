import VueRouter from 'vue-router'
import routes from './routes'

const Router = new VueRouter({
    mode : 'history',
    routes,
})

export default Router
require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

import Router from './Router'
import Store from './Store'

//font awesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrashAlt, faEdit, faEye } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faTrashAlt, faEdit, faEye )
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.use(VueRouter)
Vue.use(VueResource)

import Cms from './Components/cms'

const cms = new Vue({
    el : "#app",

    components : {
        Cms,
    },

    router : Router,
    store : Store,
})


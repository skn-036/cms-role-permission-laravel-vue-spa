import { createApp } from 'vue';
import App from './App.vue';
import './app.css';
import 'vue-select/dist/vue-select.css';
import './src/assets/css/vue-select-override.css';
import './src/utils/axios';

import router from './src/router';
import { createPinia } from 'pinia';

import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import focus from './src/directives/focus';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia)
    .use(router)
    .use(Toast, {
        pauseOnFocusLoss: false,
        hideProgressBar: true,
        timeout: 10000,
    })
    .directive('focus', focus)
    .mount('#app');

app.config.warnHandler = () => null;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//receive CORS requests from Laravel Sanctum
axios.defaults.withCredentials = true;


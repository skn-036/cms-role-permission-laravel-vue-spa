import axios from 'axios';

axios.defaults.baseURL = `${process.env.APP_URL}/api`;
axios.defaults.withCredentials = true;

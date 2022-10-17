
import {createApp} from 'vue';

require('./bootstrap');


import App from './App.vue';
import axios from 'axios';

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(require('vue-cookies'))
app.mount('#app');

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia'; 
import Vue3Notifications from '@kyvg/vue3-notification'; 

import './style.css' 

const pinia = createPinia();
const app = createApp(App);

app.use(Vue3Notifications);
app.use(router);
app.use(pinia);

app.mount('#app');
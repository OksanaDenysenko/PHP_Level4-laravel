import './bootstrap';
import { createApp } from 'vue';
import PeoplePage from "./pages/PeoplePage.vue";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token){
    window.axios.defaults.headers.common['X-CSRF-TOKEN']=token.content;
}else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const app = createApp({});

app.component('people-page', PeoplePage);

app.mount('#app');

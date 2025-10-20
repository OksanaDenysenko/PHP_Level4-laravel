import './bootstrap';
import { createApp } from 'vue';
import PeoplePage from "./pages/PeoplePage.vue";

const app = createApp({});

app.component('people-page', PeoplePage);

app.mount('#app');

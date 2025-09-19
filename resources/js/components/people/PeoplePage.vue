<template>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Список персонажів Star Wars</h1>

        <div v-if="people.data && people.data.length > 0">
            <PeopleTable :people="people.data"/>
            <Pagination :pagination="people" @page-changed="fetchPeople" />
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import PeopleTable from './PeopleTable.vue';
import Pagination from "../Pagination.vue";

const initialPeople = globalThis.initialPeople;
const people = ref(initialPeople);
const fetchPeople = async (page) => {
    if (!page) return;
    try {
        const response = await axios.get(`/people?page=${page}`, {
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        });
        history.pushState(null, '', `/people?page=${page}`);
        people.value = response.data;
    } catch (err) {
        console.error(err);
    }
};
</script>

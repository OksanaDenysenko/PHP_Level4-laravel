<template>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Список персонажів Star Wars</h1>

        <div v-if="people.length">
            <PeopleTable :people="people.data" />
            <div class="flex justify-center mt-4">
                <button
                    @click="fetchPeople(pagination.prev_page_url)"
                    :disabled="!pagination.prev_page_url"
                    class="px-4 py-2 mx-1 bg-gray-200 rounded disabled:opacity-50"
                >
                    Попередня
                </button>
                <span class="px-4 py-2 mx-1">Сторінка {{ pagination.current_page }} з {{ pagination.last_page }}</span>
                <button
                    @click="fetchPeople(pagination.next_page_url)"
                    :disabled="!pagination.next_page_url"
                    class="px-4 py-2 mx-1 bg-gray-200 rounded disabled:opacity-50"
                >
                    Наступна
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import PeopleTable from './PeopleTable.vue'; // Імпорт дочірнього компонента

const initialPeople = globalThis.initialPeople;
const people = ref(initialPeople);
const fetchPeople = async (url) => {
    const fetchPeople = async (url) => {
        if (!url) return;
        try {
            const response = await axios.get(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            people.value = response.data;
        } catch (err) {
            console.error(err);
        }
    }
};
</script>

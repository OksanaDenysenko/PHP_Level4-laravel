<template>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Список персонажів Star Wars</h1>

        <div v-if="isLoading" class="text-center py-8">
            <p>Завантаження даних...</p>
            <div
                class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-blue-600 motion-reduce:animate-[spin_1.5s_linear_infinite]">
        <span
            class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
            </div>
        </div>

        <div v-else-if="people.data && people.data.length > 0">
            <PeopleTable :people="people.data"/>
            <Pagination :pagination="people" @page-changed="fetchPeople"/>
        </div>

        <div v-else-if="!isLoading && !people.data" class="text-center py-8 text-gray-500">
            <p>Даних про персонажів не знайдено.</p>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import {getPeopleApi} from '../api/people';
import PeopleTable from '../components/people/PeopleTable.vue';
import Pagination from "../components/Pagination.vue";

const people = ref({});
const isLoading = ref(true);
const fetchPeople = async (page = 1) => {
    if (!page) return;

    isLoading.value = true;

    try {
        const data = await getPeopleApi(page);

        if (page > 1 || !data.data.length) {
            history.pushState(null, '', `/people?page=${page}`);
        }

        people.value = data;
    } catch (err) {
        console.error(err);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = urlParams.get('page') || 1;

    fetchPeople(initialPage);
});
</script>

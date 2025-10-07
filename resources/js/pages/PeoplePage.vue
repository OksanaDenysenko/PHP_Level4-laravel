<template>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold mb-4">Список персонажів Star Wars</h1>

            <button
                @click="showForm = true"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-150 ease-in-out"
            >
                Додати Персонажа
            </button>
        </div>

        <Modal :show="showForm" @close="showForm = false">
            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-2xl font-semibold mb-4">Новий Персонаж</h2>
                <PersonForm
                    @cancel="showForm = false"
                    @person-created="handlePersonAdded"
                />
            </div>
        </Modal>

        <div v-if="isLoading" class="text-center py-8">
            <p>Завантаження даних...</p>
            <div
                class="inline-block h-8 w-8 animate-spin rounded-full
                border-4 border-solid border-current border-r-transparent
                align-[-0.125em] text-blue-600
                motion-reduce:animate-[spin_1.5s_linear_infinite]">

                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden
                    !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">
                    Loading...
                </span>
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
import PersonForm from "../components/people/PersonForm.vue";
import Modal from "../components/Modal.vue";

const people = ref({});
const isLoading = ref(true);
const showForm = ref(false);
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

const handlePersonAdded = (newPerson) => {
    showForm.value = false;

    if (people.value.data) {
        people.value.data.unshift(newPerson);
    }

    if (people.value.total) {
        people.value.total += 1;
    }
}

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = urlParams.get('page') || 1;

    fetchPeople(initialPage);
});
</script>

<script setup lang="ts">
import {ref} from 'vue';
import axios from 'axios'; // Будемо використовувати axios тут

// Оголошуємо події, які компонент може випромінювати
const emit = defineEmits(['cancel', 'person-created']);

const newPerson = ref({
    name: '',
    height: '',
    mass: '',
    hair_color: '',
    skin_color: '',
    eye_color: '',
    birth_year: '',
    gender: '',
    homeworld: '',
    films: [],
    species: '',
    vehicles: '',
    starships: '',
    created: '',
    edited: '',
    url: ''
});
const isSaving = ref(false);

const savePerson = async () => {
    isSaving.value = true;
    try {
        // Виконання POST-запиту до маршруту Laravel store
        await axios.post('/people', newPerson.value);

        // Успіх: повідомляємо батьківському компоненту
        emit('person-created');

        // Скидаємо форму
        newPerson.value = {
            name: '',
            height: '',
            mass: '',
            hair_color: '',
            skin_color: '',
            eye_color: '',
            birth_year: '',
            gender: '',
            homeworld: '',
            films: [],
            species: '',
            vehicles: '',
            starships: '',
            created: '',
            edited: '',
            url: '',
        };

    } catch (error) {
        console.error("Помилка при збереженні персонажа:", error);
        // Тут можна додати логіку відображення помилок валідації
    } finally {
        isSaving.value = false;
    }
};
</script>

<template>
    <form @submit.prevent="savePerson">
        <div class="max-h-96 overflow-y-auto pr-4 mb-4">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Ім'я</label>
                <input type="text" id="name" v-model="newPerson.name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="height" class="block text-sm font-medium text-gray-700">Зріст (см)</label>
                <input type="number" id="height" v-model="newPerson.height"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="mass" class="block text-sm font-medium text-gray-700">Вага (кг)</label>
                <input type="number" id="mass" v-model="newPerson.mass"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="hair_color" class="block text-sm font-medium text-gray-700">Колір волосся</label>
                <input type="number" id="hair_color" v-model="newPerson.hair_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="mass" class="block text-sm font-medium text-gray-700">Колір шкіри</label>
                <input type="text" id="mass" v-model="newPerson.skin_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="eye_color" class="block text-sm font-medium text-gray-700">Колір очей</label>
                <input type="text" id="eye_color" v-model="newPerson.eye_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="birth_year" class="block text-sm font-medium text-gray-700">Рік народження</label>
                <input type="number" id="birth_year" v-model="newPerson.birth_year"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Стать</label>
                <select id="gender" v-model="newPerson.gender"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled>Оберіть вид</option>
                    <option value="Human">Human</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="homeworld" class="block text-sm font-medium text-gray-700">Планета</label>
                <select id="homeworld" v-model="newPerson.homeworld"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option value="" disabled>Оберіть планету</option>

                    <option value="Tatooine">Tatooine</option>
                    <option value="Alderaan">Alderaan</option>
                    <option value="Dagobah">Dagobah</option>

                </select>
            </div>

            <div class="mb-4">
                <label for="films" class="block text-sm font-medium text-gray-700">Фільми</label>
                <select name="films" v-model="newPerson.films" multiple>
                    <option value="ep4">Епізод IV: Нова надія</option>
                    <option value="ep5">Епізод V: Імперія завдає удару у відповідь</option>
                    <option value="ep6">Епізод VI: Повернення джедая</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="species" class="block text-sm font-medium text-gray-700">Вид</label>
                <input type="text" id="species" v-model="newPerson.species"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="vehicles" class="block text-sm font-medium text-gray-700">Транспортний засіб</label>
                <input type="text" id="vehicles" v-model="newPerson.vehicles"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="starships" class="block text-sm font-medium text-gray-700">Космічний корабель</label>
                <input type="text" id="starships" v-model="newPerson.starships"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="created" class="block text-sm font-medium text-gray-700">Створено</label>
                <input type="number" id="created" v-model="newPerson.created"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="edited" class="block text-sm font-medium text-gray-700">Оновлено</label>
                <input type="number" id="edited" v-model="newPerson.edited"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                <input type="url" id="url" v-model="newPerson.url"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="button"
                    @click="emit('cancel')"
                    class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-150">
                Скасувати
            </button>
            <button type="submit"
                    :disabled="isSaving"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition duration-150 disabled:opacity-50">
                {{ isSaving ? 'Зберігаю...' : 'Зберегти Персонажа' }}
            </button>
        </div>
    </form>
</template>

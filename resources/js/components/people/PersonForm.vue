<script setup lang="ts">
import {ref, onMounted} from 'vue';
import axios from 'axios'; // Будемо використовувати axios тут

// Оголошуємо події, які компонент може випромінювати
const emit = defineEmits(['cancel', 'person-created']);

const formOptions=ref({
    planets:[],
    species:[],
    films:[],
    vehicles:[],
    starships:[],
    genders:[],
});
const isLoadingOptions=ref(true);

const newPerson = ref({
    name: '',
    height: null,
    mass: null,
    hair_color: '',
    skin_color: '',
    eye_color: '',
    birth_year: '',
    gender: '',
    planet_id: null,
    species_id: null,
    film_ids: [],
    vehicle_ids: [],
    starship_ids: []
});
const isSaving = ref(false);
const validationErrors=ref({});

const fetchFormOptions=async ()=>{
    isLoadingOptions.value=true;
    try {
        const response=await axios.get('/api/person-form-options');
        formOptions.value=response.data;
    }catch (error) {
        console.error("Помилка завантаження опцій форми:", error);
        //Can look messedge user
    }finally {
        isLoadingOptions.value=false;
    }
}

onMounted(()=>{
    fetchFormOptions();
});

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
            height: null,
            mass: null,
            hair_color: '',
            skin_color: '',
            eye_color: '',
            birth_year: '',
            gender: '',
            planet_id: null,
            species_id: null,
            film_ids: [],
            vehicle_ids: [],
            starship_ids: []
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
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" v-model="newPerson.name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="height" class="block text-sm font-medium text-gray-700">Height (см)</label>
                <input type="number" id="height" v-model="newPerson.height"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="mass" class="block text-sm font-medium text-gray-700">Mass (кг)</label>
                <input type="number" id="mass" v-model="newPerson.mass"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="hair_color" class="block text-sm font-medium text-gray-700">Hair Color</label>
                <input type="text" id="hair_color" v-model="newPerson.hair_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="skin_color" class="block text-sm font-medium text-gray-700">Skin Color</label>
                <input type="text" id="skin_color" v-model="newPerson.skin_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="eye_color" class="block text-sm font-medium text-gray-700">Eye Color</label>
                <input type="text" id="eye_color" v-model="newPerson.eye_color"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="birth_year" class="block text-sm font-medium text-gray-700">Birth Year</label>
                <input type="number" id="birth_year" v-model="newPerson.birth_year"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" v-model="newPerson.gender" :disabled="isLoadingOptions"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled>Оберіть стать</option>
                    <option v-for="genderValue in formOptions.genders" :key="genderValue" :value="genderValue">
                        {{genderValue}}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="homeworld" class="block text-sm font-medium text-gray-700">Homeworld</label>
                <select id="homeworld" v-model="newPerson.planet_id" :disabled="isLoadingOptions"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option value="" disabled>Оберіть планету</option>

                    <option v-for="planet in formOptions.planets" :key="planet.id" :value="planet.id">
                    {{planet.name}}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="species" class="block text-sm font-medium text-gray-700">Species</label>
                <select id="species" v-model="newPerson.species_id" :disabled="isLoadingOptions"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option value="" disabled>Оберіть вид</option>

                    <option v-for="species in formOptions.species" :key="species.id" :value="species.id">
                        {{species.name}}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="films" class="block text-sm font-medium text-gray-700">Films</label>
                <select id="films" v-model="newPerson.film_ids" multiple :disabled="isLoadingOptions">
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option v-for="film in formOptions.films" :key="film.id" :value="film.id">
                        {{ film.title }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="vehicles" class="block text-sm font-medium text-gray-700">Vehicles</label>
                <select id="vehicles" v-model="newPerson.vehicle_ids" multiple :disabled="isLoadingOptions">
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option v-for="vehicle in formOptions.vehicles" :key="vehicle.id" :value="vehicle.id">
                        {{ vehicle.name }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="starships" class="block text-sm font-medium text-gray-700">Starships</label>
                <select id="starships" v-model="newPerson.starship_ids" multiple :disabled="isLoadingOptions">
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <option v-for="starship in formOptions.starships" :key="starship.id" :value="starship.id">
                        {{ starship.name }}
                    </option>
                </select>
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

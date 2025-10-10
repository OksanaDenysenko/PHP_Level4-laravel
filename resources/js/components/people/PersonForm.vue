<script setup lang="ts">

import {ref, onMounted} from 'vue';
import FormInput from '../form/FormInput.vue';
import FormSelect from '../form/FormSelect.vue';
import FormMultiSelect from '../form/FormMultiSelect.vue';
import { getFormOptionsApi, savePersonApi } from '../../api/personForm';

const emit = defineEmits(['cancel', 'person-created']);

const initialPersonState = {
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
    film_ids: [] as number[],
    vehicle_ids: [] as number[],
    starship_ids: [] as number[],
};
const textInputFields = [
    { id: 'name', label: 'Name', type: 'text', required: true },
    { id: 'height', label: 'Height (см)', type: 'number' },
    { id: 'mass', label: 'Mass (кг)', type: 'number' },
    { id: 'hair_color', label: 'Hair Color', type: 'text' },
    { id: 'skin_color', label: 'Skin Color', type: 'text' },
    { id: 'eye_color', label: 'Eye Color', type: 'text' },
    { id: 'birth_year', label: 'Birth Year', type: 'text' },
];
const singleSelectFields = [
    { id: 'gender', label: 'Gender', modelKey: 'gender', optionsKey: 'genders',
        placeholder: 'Оберіть стать', isObjectOptions: false},
    { id: 'homeworld', label: 'Homeworld', modelKey: 'planet_id', optionsKey: 'planets',
        placeholder: 'Оберіть планету', optionLabelKey: 'name'},
    { id: 'species', label: 'Species', modelKey: 'species_id', optionsKey: 'species',
        placeholder: 'Оберіть вид', optionLabelKey: 'name'},
];
const multiSelectFields = [
    { id: 'films', label: 'Films', modelKey: 'film_ids', optionsKey: 'films', optionLabelKey: 'title'},
    { id: 'vehicles', label: 'Vehicles', modelKey: 'vehicle_ids', optionsKey: 'vehicles', optionLabelKey: 'name'},
    { id: 'starships', label: 'Starships', modelKey: 'starship_ids', optionsKey: 'starships', optionLabelKey: 'name'},
];

const formOptions = ref({
    planets: [],
    species: [],
    films: [],
    vehicles: [],
    starships: [],
    genders: [],
});
const newPerson = ref({...initialPersonState});
const isLoadingOptions = ref(true);
const isSaving = ref(false);
const validationErrors = ref({});
const generalError = ref('');

const fetchFormOptions = async () => {
    isLoadingOptions.value = true;

    try {
               formOptions.value = await getFormOptionsApi();
    } catch (error) {
        console.error("Помилка завантаження опцій форми:", error);
    } finally {
        isLoadingOptions.value = false;
    }
}

const savePerson = async () => {
        isSaving.value = true;
        validationErrors.value = {};
        generalError.value = '';

        try {
            const createdPerson = await savePersonApi(newPerson.value);
            emit('person-created', createdPerson);
            newPerson.value = {...initialPersonState};
        } catch (error) {
            console.error("Помилка при збереженні персонажа:", error);
            if (error.response && error.response.status === 422) {
                validationErrors.value = error.response.data.errors;
            } else {
                let errorMessage = 'Виникла невідома помилка при збереженні. Спробуйте пізніше.';

                if (error.response) {
                    errorMessage = `Помилка сервера: ${error.response.status}. `
                        + (error.response.data.message || 'Внутрішня помилка сервера.');
                } else if (error.message) {
                    errorMessage = `Помилка мережі: ${error.message}. Перевірте з'єднання.`;
                }

                generalError.value = errorMessage;
            }
        } finally {
            isSaving.value = false;
        }
    };

onMounted(() => {
    fetchFormOptions();
});
</script>

<template>
    <form @submit.prevent="savePerson">
        <div v-if="generalError"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Помилка!</strong> {{ generalError }}
        </div>
        <div v-else-if="Object.keys(validationErrors).length"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Упс!</strong>  Будь ласка, перевірте виділені поля форми.
        </div>
        <div class="max-h-96 overflow-y-auto pr-4 mb-4">
            <template v-for="field in textInputFields" :key="field.id">
                <FormInput
                    :id="field.id"
                    :label="field.label"
                    :type="field.type"
                    :required="field.required || false"
                    v-model="newPerson[field.id]"
                    :error="validationErrors[field.id]"
                />
            </template>

            <template v-for="field in singleSelectFields" :key="field.id">
                <FormSelect
                    :id="field.id"
                    :label="field.label"
                    :disabled="isLoadingOptions"
                    :placeholder="field.placeholder"
                    v-model="newPerson[field.modelKey]"
                    :options="formOptions[field.optionsKey]"
                    :is-object-options="field.isObjectOptions"
                    :option-label-key="field.optionLabelKey"
                    :error="validationErrors[field.modelKey]"
                />
            </template>

            <template v-for="field in multiSelectFields" :key="field.id">
                <FormMultiSelect
                    :id="field.id"
                    :label="field.label"
                    :disabled="isLoadingOptions"
                    v-model="newPerson[field.modelKey]"
                    :options="formOptions[field.optionsKey]"
                    :option-label-key="field.optionLabelKey"
                    :error="validationErrors[field.modelKey]"
                />
            </template>
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

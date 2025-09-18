<template>
    <div class="overflow-x-auto border border-gray-400 rounded-lg shadow-md">
        <table class="min-w-full table-fixed border-collapse bg-white">
            <thead class="bg-gray-100 border-b border-gray-400">
            <tr>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Name</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Height</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Mass</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Hair Color</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Skin Color</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Eye Color</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Birth Year</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Gender</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Homeworld</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Films</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Species</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Vehicles</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-400">Starships</th>
                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="person in people" :key="person.name" class="border-b border-gray-400 hover:bg-gray-50">
                <td class="px-2 py-4 text-sm text-gray-900 border-r border-gray-400 break-words">{{ person.name }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.height }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.mass }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.hair_color }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.skin_color }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.eye_color }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.birth_year }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.gender }}</td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <span v-if="person.homeworld" class="text-blue-500 hover:underline">{{ person.homeworld }}</span>
                </td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <ul class="list-disc list-inside">
                        <li v-for="film in person.films" :key="film" class="text-blue-500 hover:underline">
                            {{ film.split('/').slice(-2, -1)[0] }}
                        </li>
                    </ul>
                </td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <span v-if="person.species.length">...</span>
                </td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <span v-if="person.vehicles.length">...</span>
                </td>
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <span v-if="person.starships.length">...</span>
                </td>
                <td class="px-2 py-4 text-sm font-medium border-r border-gray-400 break-words">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Редагувати</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    people: {
        type: Array,
        required: true
    }
});
</script>

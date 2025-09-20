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
                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.planet?.name}}</td>

                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <ul v-if="person.films && person.films.length">
                        <li v-for="film in person.films" :key="film.id">{{ film.title }}</li>
                    </ul>
                </td>

                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">{{ person.species ?.name }} </td>

                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <ul v-if="person.vehicles && person.vehicles.length">
                        <li v-for="vehicle in person.vehicles" :key="vehicle.id">{{ vehicle.name }}</li>
                    </ul>
                </td>

                <td class="px-2 py-4 text-sm text-gray-500 border-r border-gray-400 break-words">
                    <ul v-if="person.starships && person.starships.length">
                        <li v-for="starship in person.starships" :key="starship.id">{{ starship.name }}</li>
                    </ul>
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

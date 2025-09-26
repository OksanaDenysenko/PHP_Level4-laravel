<template>
    <div class="flex justify-center mt-4">
        <button
            @click="$emit('page-changed', pagination.current_page - 1)"
            :disabled="!pagination.prev_page_url"
            class="px-4 py-2 mx-1 bg-gray-200 rounded disabled:opacity-50"
        >
            Попередня
        </button>
        <span class="px-4 py-2 mx-1">Сторінка {{ pagination.current_page }} з {{ pagination.last_page }}</span>
        <button
            @click="$emit('page-changed',  pagination.current_page + 1)"
            :disabled="!pagination.next_page_url"
            class="px-4 py-2 mx-1 bg-gray-200 rounded disabled:opacity-50"
        >
            Наступна
        </button>
    </div>
</template>

<script setup>

const props = defineProps({
    pagination: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['page-changed']);
</script>

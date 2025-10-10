<script setup lang="ts">

defineProps({
    show: { type: Boolean, required: true },
});

const emit = defineEmits(['close']);

const closeOnBackground = (event) => {
    if (event.target === event.currentTarget) {
        emit('close');
    }
}
</script>

<template>
    <div v-if="show" @click="closeOnBackground"
         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-700 bg-opacity-10">

        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
            <slot />
        </div>

    </div>
</template>

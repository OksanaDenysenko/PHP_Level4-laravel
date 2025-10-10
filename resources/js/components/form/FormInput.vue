<script setup lang="ts">

defineProps({
    id: { type: String, required: true },
    label: { type: String, required: true },
    type: { type: String, default: 'text' },
    modelValue: { type: [String, Number, null], default: '' },
    error: { type: Array, default: null },
    required: { type: Boolean, default: false },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <input
            :type="type"
            :id="id"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :required="required"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        >
        <div v-if="error" class="text-sm text-red-600 mt-1">
            {{ error[0] }}
        </div>
    </div>
</template>

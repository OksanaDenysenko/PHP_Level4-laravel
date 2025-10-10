<script setup lang="ts">

const props = defineProps({
    id: { type: String, required: true },
    label: { type: String, required: true },
    modelValue: { type: Array, required: true },
    options: { type: Array, required: true },
    disabled: { type: Boolean, default: false },
    optionLabelKey: { type: String, default: 'name' },
    error: { type: Array, default: null },
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const selectedOptions: number[] = Array.from(target.options)
        .filter(option => option.selected)
        .map(option => parseInt(option.value)); // Конвертуємо в число

    emit('update:modelValue', selectedOptions);
};
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <select
            :id="id"

            @change="updateValue"
            multiple
            :disabled="disabled"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        >
            <option v-for="opt in options" :key="opt.id" :value="opt.id" :selected="modelValue.includes(opt.id)">
                {{ opt[optionLabelKey] }}
            </option>
        </select>
        <div v-if="error" class="text-sm text-red-600 mt-1">
            {{ error[0] }}
        </div>
    </div>
</template>

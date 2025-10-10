<script setup lang="ts">

defineProps({
    id: { type: String, required: true },
    label: { type: String, required: true },
    modelValue: { type: [String, Number, null], default: '' },
    options: { type: Array, required: true },
    placeholder: { type: String, default: 'Оберіть' },
    disabled: { type: Boolean, default: false },
    isObjectOptions: { type: Boolean, default: true },
    optionLabelKey: { type: String, default: 'name' },
    error: { type: Array, default: null },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <select
            :id="id"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            :disabled="disabled"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        >
            <option value="" disabled>{{ placeholder }}</option>

            <template v-if="!isObjectOptions">
                <option v-for="opt in options" :key="opt" :value="opt">
                    {{ opt }}
                </option>
            </template>

            <template v-else>
                <option v-for="opt in options" :key="opt.id" :value="opt.id">
                    {{ opt[optionLabelKey] }}
                </option>
            </template>
        </select>

        <div v-if="error" class="text-sm text-red-600 mt-1">
            {{ error[0] }}
        </div>

    </div>
</template>

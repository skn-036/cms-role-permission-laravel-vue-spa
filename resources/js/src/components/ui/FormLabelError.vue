<script setup>
import { ref } from 'vue';
import { v4 } from 'uuid';

const props = defineProps({
    label: {
        type: String,
        default: () => '',
    },
    labelClass: {
        type: String,
        default: () => '',
    },
    error: {
        type: [String, null],
        default: () => null,
    },
    errorClass: {
        type: String,
        default: () => '',
    },
    required: {
        type: Boolean,
        default: () => false,
    },
});

const id = ref(`input-${v4()}`);
</script>

<template>
    <div class="w-full">
        <label
            v-if="label"
            :for="id"
            class="block mb-2 text-sm font-semibold"
            :class="[labelClass ? labelClass : '']"
        >
            {{ label }}
            <span
                v-if="required"
                class="text-red-700 dark:text-rose-500 ml-1"
                >*</span
            >
        </label>
        <slot></slot>
        <div
            v-if="error"
            class="w-full text-red-600 dark:text-rose-500 text-xs mt-1"
            :class="[errorClass ? errorClass : '']"
        >
            {{ error }}
        </div>
    </div>
</template>

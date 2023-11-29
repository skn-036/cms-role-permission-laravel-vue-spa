<script setup>
import { computed, ref } from 'vue';
import FormLabelError from './FormLabelError.vue';

import { v4 } from 'uuid';

const props = defineProps({
    modelValue: {
        required: false,
    },
    type: {
        type: String,
        default: () => 'text',
    },
    label: {
        type: String,
    },
    labelClass: {
        type: String,
        default: () => '',
    },
    placeholder: {
        type: String,
    },
    disabled: {
        type: Boolean,
        default: () => false,
    },
    inputClass: {
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
    focus: {
        type: Boolean,
        default: () => false,
    },
    required: {
        type: Boolean,
        default: () => false,
    },
    step: {
        type: [String, Number, null],
        default: () => null,
    },
    vModelOnBlur: {
        type: Boolean,
        default: () => false,
    },
});

const emit = defineEmits(['update:modelValue', 'focus', 'blur']);

const value = computed({
    get: () => props.modelValue,
    set: (value) => {
        if (!props.vModelOnBlur) emit('update:modelValue', value);
    },
});
const id = ref(`input-${v4()}`);

const onKeydown = (event) => {
    if (props.type !== 'number') return;
    disableKeys(event, ['e', 'E']);
};

const onFocus = (event) => {
    emit('focus', event?.target?.value ? event.target.value : null, event);
};

const onBlur = (event) => {
    const val = event?.target?.value ? event.target.value : null;
    emit('blur', val, event);
    if (props.vModelOnBlur) emit('update:modelValue', val);
};

const disableKeys = (event, keys = ['e', 'E', '+', '-']) => {
    if (!keys) return;
    keys.includes(event.key) && event.preventDefault();
};
</script>

<template>
    <FormLabelError
        :label="label"
        :label-class="labelClass"
        :error="error"
        error-class="errorClass"
        :required="required"
    >
        <input
            v-model="value"
            v-focus.select="focus"
            :id="id"
            :type="type"
            :step="step ? step : type === 'number' ? 'any' : null"
            class="bg-gray-50 border border-gray-300 sm:text-sm rounded-sm block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:ring-2 focus:ring-active focus:border-active dark:focus:ring-active dark:focus:border-active outline-none"
            :placeholder="placeholder ? placeholder : ''"
            :class="[
                disabled ? 'cursor-not-allowed' : '',
                inputClass ? inputClass : '',
            ]"
            :disabled="disabled"
            @keydown="onKeydown"
            @focus="onFocus"
            @blur="onBlur"
        />
    </FormLabelError>
</template>

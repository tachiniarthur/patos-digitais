<template>
    <textarea
        :value="modelValue"
        :placeholder="placeholder"
        class="block w-full text-sm text-gray-900 rounded-lg border bg-white border-primary-300 focus:ring-primary-500 focus:border-primary-500"
        ref="textarea"
        @input="updateValue"
    ></textarea>
</template>

<script setup>
import { ref, onMounted, defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
};

defineExpose({ focus: () => textarea.value.focus() });
</script>

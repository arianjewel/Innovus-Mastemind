<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: Boolean,
    label: String,
    error: String,
});
const emit = defineEmits(['update:modelValue']);

const toggle = () => emit('update:modelValue', !props.modelValue);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">{{ label }}</label>
        <button
            type="button"
            @click="toggle"
            class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition"
            :class="modelValue ? 'bg-brand-600' : 'bg-slate-300'"
        >
            <span
                class="inline-block h-4.5 w-4.5 transform rounded-full bg-white shadow transition"
                :class="modelValue ? 'translate-x-[22px]' : 'translate-x-1'"
                style="height: 18px; width: 18px;"
            ></span>
        </button>
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
defineProps({
    modelValue: [String, Number, Boolean],
    label: String,
    options: { type: Array, default: () => [] },
    error: String,
    hint: String,
    required: Boolean,
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>
        <select
            :value="modelValue"
            :required="required"
            @change="$emit('update:modelValue', $event.target.value)"
            class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm outline-none transition focus:ring-1"
            :class="error
                ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                : 'border-slate-300 focus:border-brand-500 focus:ring-brand-500'"
        >
            <option v-for="opt in options" :key="String(opt.value)" :value="opt.value">{{ opt.label }}</option>
        </select>
        <p v-if="hint" class="mt-1 text-[11px] text-slate-400">{{ hint }}</p>
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

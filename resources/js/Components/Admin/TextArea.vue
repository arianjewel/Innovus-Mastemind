<script setup>
defineProps({
    modelValue: [String, Number],
    label: String,
    rows: { type: Number, default: 4 },
    error: String,
    hint: String,
    required: Boolean,
    placeholder: String,
    monospace: Boolean,
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>
        <textarea
            :value="modelValue"
            :rows="rows"
            :placeholder="placeholder"
            :required="required"
            :class="[monospace ? 'font-mono text-xs' : '', error
                ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                : 'border-slate-300 focus:border-brand-500 focus:ring-brand-500']"
            @input="$emit('update:modelValue', $event.target.value)"
            class="w-full rounded-lg border px-3.5 py-2.5 text-sm outline-none transition focus:ring-1"
        ></textarea>
        <p v-if="hint" class="mt-1 text-[11px] text-slate-400">{{ hint }}</p>
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
import { TrashIcon, PlusIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    modelValue: { type: Array, default: () => [] },
    label: String,
    placeholder: { type: String, default: 'Enter item…' },
    addLabel: { type: String, default: 'Add Item' },
    error: String,
});
const emit = defineEmits(['update:modelValue']);

function add() {
    const items = [...props.modelValue];
    if (items.length && !String(items.at(-1) ?? '').trim()) return;
    items.push('');
    emit('update:modelValue', items);
}

function update(i, val) {
    const items = [...props.modelValue];
    items[i] = val;
    emit('update:modelValue', items);
}

function remove(i) {
    const items = [...props.modelValue];
    items.splice(i, 1);
    emit('update:modelValue', items);
}
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">{{ label }}</label>
        <div class="space-y-2">
            <div v-for="(item, i) in modelValue" :key="i" class="flex items-center gap-2">
                <span class="w-6 text-center text-xs font-bold text-slate-400">{{ i + 1 }}</span>
                <input
                    :value="item"
                    :placeholder="placeholder"
                    @input="update(i, $event.target.value)"
                    class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                />
                <button
                    type="button"
                    @click="remove(i)"
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                    aria-label="Remove"
                >
                    <TrashIcon class="h-4 w-4" />
                </button>
            </div>
            <button
                type="button"
                @click="add"
                class="inline-flex items-center gap-1.5 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-xs font-semibold text-slate-500 transition hover:border-brand-400 hover:text-brand-600"
            >
                <PlusIcon class="h-4 w-4" /> {{ addLabel }}
            </button>
        </div>
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

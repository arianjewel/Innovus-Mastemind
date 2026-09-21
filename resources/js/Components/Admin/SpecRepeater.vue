<script setup>
const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    label: String,
    keyPlaceholder: { type: String, default: 'Name' },
    valuePlaceholder: { type: String, default: 'Value' },
    addLabel: { type: String, default: 'Add Spec' },
    error: String,
});
const emit = defineEmits(['update:modelValue']);

const entries = () => Object.entries(props.modelValue ?? {});

function add() {
    const data = { ...props.modelValue };
    const keys = Object.keys(data);
    if (keys.length && !String(keys.at(-1)).trim()) return;
    let name = '';
    let n = keys.length + 1;
    while (Object.prototype.hasOwnProperty.call(data, name)) { name = `Spec ${n++}`; }
    data[name] = '';
    emit('update:modelValue', data);
}

function updateKey(oldKey, newKey) {
    if (oldKey === newKey) return;
    const data = {};
    for (const [k, v] of Object.entries(props.modelValue)) {
        data[k === oldKey ? newKey : k] = v;
    }
    emit('update:modelValue', data);
}

function updateValue(key, val) {
    emit('update:modelValue', { ...props.modelValue, [key]: val });
}

function remove(key) {
    const data = { ...props.modelValue };
    delete data[key];
    emit('update:modelValue', data);
}
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">{{ label }}</label>
        <div class="space-y-2">
            <div v-for="(value, key) in modelValue" :key="key" class="flex items-center gap-2">
                <input
                    :value="key"
                    :placeholder="keyPlaceholder"
                    @change="updateKey(key, $event.target.value)"
                    class="w-40 shrink-0 rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:bg-white focus:ring-1 focus:ring-brand-500"
                />
                <input
                    :value="value"
                    :placeholder="valuePlaceholder"
                    @input="updateValue(key, $event.target.value)"
                    class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                />
                <button
                    type="button"
                    @click="remove(key)"
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                    aria-label="Remove"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                </button>
            </div>
            <button
                type="button"
                @click="add"
                class="inline-flex items-center gap-1.5 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-xs font-semibold text-slate-500 transition hover:border-brand-400 hover:text-brand-600"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                {{ addLabel }}
            </button>
        </div>
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

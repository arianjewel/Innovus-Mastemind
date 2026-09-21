<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: [File, Array, FileList],
    label: String,
    accept: { type: String, default: 'image/*' },
    multiple: Boolean,
    error: String,
    hint: String,
});
const emit = defineEmits(['update:modelValue']);

const input = ref(null);
const previews = ref([]);

function onPick(e) {
    const files = Array.from(e.target.files || []);
    emit('update:modelValue', props.multiple ? files : (files[0] ?? null));
    previews.value = files.map((f) => URL.createObjectURL(f));
}

const hasPreview = computed(() => previews.value.length > 0);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-xs font-semibold text-slate-600">{{ label }}</label>
        <div
            @click="input?.click()"
            class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed px-6 py-6 text-center transition hover:border-brand-400 hover:bg-brand-50/40"
            :class="error ? 'border-red-300 bg-red-50/30' : 'border-slate-300'"
        >
            <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            <p class="mt-2 text-sm text-slate-500">Click to choose {{ multiple ? 'file(s)' : 'a file' }}</p>
            <p v-if="hint" class="mt-1 text-[11px] text-slate-400">{{ hint }}</p>
        </div>

        <div v-if="hasPreview" class="mt-3 flex flex-wrap gap-2">
            <img v-for="(src, i) in previews" :key="i" :src="src" class="h-16 w-16 rounded-lg border border-slate-200 object-cover" />
        </div>

        <input ref="input" type="file" :accept="accept" :multiple="multiple" class="hidden" @change="onPick" />
        <p v-if="error" class="mt-1 text-xs font-medium text-red-600">{{ error }}</p>
    </div>
</template>

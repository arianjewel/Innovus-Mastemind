<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: { type: Array, required: true },
    only: { type: Array, default: () => [] },
    preserveScroll: { type: Boolean, default: true },
});

const visible = computed(() => props.links.filter((l) => !l.label.includes('…')));
</script>

<template>
    <nav v-if="links.length > 3" class="flex items-center justify-center flex-wrap gap-1.5 mt-10" aria-label="Pagination">
        <template v-for="(link, i) in links" :key="i">
            <span
                v-if="!link.url"
                class="px-3.5 py-2 rounded-md text-sm border"
                :class="link.active ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-slate-400 border-slate-200'"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                :only="only"
                :preserve-scroll="preserveScroll"
                class="px-3.5 py-2 rounded-md text-sm border transition hover:border-brand-500"
                :class="link.active
                    ? 'bg-brand-600 text-white border-brand-600 font-semibold'
                    : 'bg-white text-slate-700 border-slate-200'"
                v-html="link.label"
            />
        </template>
    </nav>
</template>

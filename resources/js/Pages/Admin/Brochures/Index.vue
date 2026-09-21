<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ brochures: Array });

const destroy = (id) => {
    if (confirm('Delete this brochure? The flipbook will be empty until a new one is uploaded.')) {
        router.delete(route('admin.brochures.destroy', id), { preserveScroll: true });
    }
};

const fmtSize = (bytes) => {
    let b = bytes || 0;
    const units = ['B', 'KB', 'MB'];
    let i = 0;
    while (b >= 1024 && i < units.length - 1) { b /= 1024; i++; }
    return `${b.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
};
</script>

<template>
    <Head title="E-Brochure" />

    <AdminLayout>
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-navy-900">E-Brochure</h1>
                <p class="text-sm text-slate-500">Company profile PDF shown in the public flipbook at /ebrochure.</p>
            </div>
            <div class="flex items-center gap-2">
                <a v-if="brochures.some((b) => b.is_active)" href="/ebrochure" target="_blank" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-brand-400 hover:text-brand-700">
                    Preview Flipbook ↗
                </a>
                <Link :href="route('admin.brochures.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Upload Brochure
                </Link>
            </div>
        </div>

        <div v-if="brochures.length" class="space-y-4">
            <article
                v-for="b in brochures"
                :key="b.id"
                class="flex flex-wrap items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >
                <span class="grid h-14 w-14 shrink-0 place-items-center rounded-xl bg-red-50 text-red-600">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 12h6m-6 3.75h3.75M6.75 21h10.5A2.25 2.25 0 0019.5 18.75V8.297c0-.596-.237-1.167-.658-1.587l-2.052-2.052a2.25 2.25 0 00-1.587-.658H6.75A2.25 2.25 0 004.5 6.25v12.5A2.25 2.25 0 006.75 21z"/></svg>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-slate-800">{{ b.title }}</p>
                    <p class="mt-0.5 text-xs text-slate-400">PDF · {{ fmtSize(b.size_bytes) }} · {{ b.downloads }} downloads</p>
                    <p v-if="b.description" class="mt-1 line-clamp-1 text-xs text-slate-500">{{ b.description }}</p>
                </div>
                <span
                    :class="b.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'"
                    class="rounded-full px-2.5 py-1 text-[11px] font-bold uppercase"
                >
                    {{ b.is_active ? 'Published' : 'Draft' }}
                </span>
                <div class="whitespace-nowrap text-sm font-medium">
                    <Link :href="route('admin.brochures.edit', b.id)" class="text-brand-600 hover:text-brand-800">Edit</Link>
                    <button @click="destroy(b.id)" class="ml-4 text-red-500 hover:text-red-700">Delete</button>
                </div>
            </article>
        </div>
        <p v-else class="rounded-2xl border border-dashed border-slate-300 py-16 text-center text-sm text-slate-400">No brochures uploaded yet.</p>
    </AdminLayout>
</template>

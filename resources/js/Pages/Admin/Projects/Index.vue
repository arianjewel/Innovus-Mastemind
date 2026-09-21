<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    projects: Object,
    filters: Object,
});

const search = ref(props.filters.search ?? '');
let debounce;

watch(search, (val) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        router.get(route('admin.projects.index'), { search: val }, {
            preserveState: true,
            preserveScroll: true,
            only: ['projects'],
            replace: true,
        });
    }, 350);
});

const typeLabels = { consultancy: 'Consultancy', construction: 'Construction', supply: 'Supply' };
const typeColors = {
    consultancy: 'bg-sky-100 text-sky-700',
    construction: 'bg-brand-100 text-brand-800',
    supply: 'bg-amber-100 text-amber-700',
};

const destroy = (id) => {
    if (confirm('Delete this project, its gallery and documents?')) {
        router.delete(route('admin.projects.destroy', id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Projects" />

    <AdminLayout>
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Projects</h1>
                <p class="text-sm text-slate-500">{{ projects.total }} project(s).</p>
            </div>
            <div class="flex items-center gap-3">
                <input
                    v-model="search"
                    type="search"
                    placeholder="Search title or client…"
                    class="w-60 rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                />
                <Link :href="route('admin.projects.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    New Project
                </Link>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="projects.data.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Project</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Client / Location</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Type</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Docs</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="p in projects.data" :key="p.id" class="hover:bg-slate-50/70">
                        <td class="flex items-center gap-3 px-5 py-3">
                            <img :src="p.image_path ? `/storage/${p.image_path}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(p.title)}&background=0f2436&color=fff&size=96`" class="h-11 w-16 shrink-0 rounded-lg border border-slate-200 object-cover" />
                            <div class="min-w-0">
                                <p class="truncate font-medium text-slate-800">{{ p.title }}</p>
                                <p v-if="p.is_featured" class="text-[10px] font-bold uppercase text-amber-500">★ Featured</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <p class="text-slate-700">{{ p.client || '—' }}</p>
                            <p class="text-[11px] text-slate-400">{{ p.location }}</p>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span :class="typeColors[p.type]" class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase">{{ typeLabels[p.type] }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span :class="p.status === 'ongoing' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase">{{ p.status }}</span>
                        </td>
                        <td class="px-5 py-3 text-center tabular-nums text-slate-600">{{ p.documents_count ?? 0 }}</td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <Link :href="route('admin.projects.edit', p.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(p.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">No projects found.</p>

            <Pagination v-if="projects.last_page > 1" :links="projects.links" :only="['projects']" class="border-t border-slate-100" />
        </div>
    </AdminLayout>
</template>

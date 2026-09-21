<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ clients: Array });

const destroy = (id) => {
    if (confirm('Remove this client?')) {
        router.delete(route('admin.clients.destroy', id), { preserveScroll: true });
    }
};

const toggleActive = (c) => {
    router.patch(route('admin.clients.update', c.id), {
        name: c.name,
        website: c.website,
        sort_order: c.sort_order,
        is_active: !c.is_active,
    }, { preserveScroll: true, only: ['clients', 'flash'] });
};
</script>

<template>
    <Head title="Clients" />

    <AdminLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Clients</h1>
                <p class="text-sm text-slate-500">Client logos shown in the homepage marquee.</p>
            </div>
            <Link :href="route('admin.clients.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Client
            </Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="clients.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Client</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Website</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="c in clients" :key="c.id" class="hover:bg-slate-50/70">
                        <td class="flex items-center gap-3 px-5 py-3">
                            <img v-if="c.logo_path" :src="`/storage/${c.logo_path}`" class="h-9 w-14 rounded-lg border border-slate-200 bg-white object-contain p-1" />
                            <span class="font-medium text-slate-800">{{ c.name }}</span>
                        </td>
                        <td class="max-w-[220px] truncate px-5 py-3">
                            <a v-if="c.website" :href="c.website" target="_blank" rel="noopener" class="text-brand-600 hover:underline">{{ c.website }}</a>
                            <span v-else class="text-slate-400">—</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <button
                                @click="toggleActive(c)"
                                class="rounded-full px-2.5 py-1 text-[11px] font-bold uppercase transition"
                                :class="c.is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'"
                            >
                                {{ c.is_active ? 'Live' : 'Hidden' }}
                            </button>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <Link :href="route('admin.clients.edit', c.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(c.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">No clients yet.</p>
        </div>
    </AdminLayout>
</template>

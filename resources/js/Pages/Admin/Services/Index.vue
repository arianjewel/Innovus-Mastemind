<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ services: Array });

const destroy = (id) => {
    if (confirm('Delete this service?')) {
        router.delete(route('admin.services.destroy', id), { preserveScroll: true });
    }
};

const toggleActive = (svc) => {
    router.patch(route('admin.services.update', svc.id), {
        title: svc.title,
        icon: svc.icon,
        short_desc: svc.short_desc,
        description: svc.description,
        features: svc.features ?? [],
        sort_order: svc.sort_order,
        is_active: !svc.is_active,
    }, { preserveScroll: true, only: ['services', 'flash'] });
};
</script>

<template>
    <Head title="Services" />

    <AdminLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Services</h1>
                <p class="text-sm text-slate-500">Core services displayed on homepage & services page.</p>
            </div>
            <Link :href="route('admin.services.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Service
            </Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="services.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Service</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Short Description</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Order</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="s in services" :key="s.id" class="hover:bg-slate-50/70">
                        <td class="px-5 py-3">
                            <p class="font-medium text-slate-800">{{ s.title }}</p>
                            <p v-if="s.icon" class="text-[11px] uppercase tracking-wide text-slate-400">{{ s.icon }}</p>
                        </td>
                        <td class="max-w-[280px] truncate px-5 py-3 text-slate-500">{{ s.short_desc || '—' }}</td>
                        <td class="px-5 py-3 text-center tabular-nums text-slate-600">{{ s.sort_order }}</td>
                        <td class="px-5 py-3 text-center">
                            <button
                                @click="toggleActive(s)"
                                class="rounded-full px-2.5 py-1 text-[11px] font-bold uppercase transition"
                                :class="s.is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'"
                            >
                                {{ s.is_active ? 'Live' : 'Hidden' }}
                            </button>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <Link :href="route('admin.services.edit', s.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(s.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">No services yet.</p>
        </div>
    </AdminLayout>
</template>

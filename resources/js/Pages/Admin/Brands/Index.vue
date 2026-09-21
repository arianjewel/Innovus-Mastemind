<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ brands: Array });

const destroy = (id) => {
    if (confirm('Delete this brand?')) {
        router.delete(route('admin.brands.destroy', id), { preserveScroll: true });
    }
};

const toggleActive = (b) => {
    router.patch(route('admin.brands.update', b.id), {
        name: b.name,
        website: b.website,
        sort_order: b.sort_order,
        is_active: !b.is_active,
    }, { preserveScroll: true, only: ['brands', 'flash'] });
};
</script>

<template>
    <Head title="Brands" />

    <AdminLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Brands</h1>
                <p class="text-sm text-slate-500">Manufacturer / supplier brands we represent.</p>
            </div>
            <Link :href="route('admin.brands.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Brand
            </Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="brands.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Brand</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Website</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Products</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="b in brands" :key="b.id" class="hover:bg-slate-50/70">
                        <td class="flex items-center gap-3 px-5 py-3">
                            <img v-if="b.logo_path" :src="`/storage/${b.logo_path}`" class="h-9 w-9 rounded-lg border border-slate-200 bg-white object-contain p-1" />
                            <span class="font-medium text-slate-800">{{ b.name }}</span>
                        </td>
                        <td class="max-w-[220px] truncate px-5 py-3">
                            <a v-if="b.website" :href="b.website" target="_blank" rel="noopener" class="text-brand-600 hover:underline">{{ b.website }}</a>
                            <span v-else class="text-slate-400">—</span>
                        </td>
                        <td class="px-5 py-3 text-center tabular-nums text-slate-600">{{ b.products_count }}</td>
                        <td class="px-5 py-3 text-center">
                            <button
                                @click="toggleActive(b)"
                                class="rounded-full px-2.5 py-1 text-[11px] font-bold uppercase transition"
                                :class="b.is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'"
                            >
                                {{ b.is_active ? 'Live' : 'Hidden' }}
                            </button>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <Link :href="route('admin.brands.edit', b.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(b.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">No brands yet.</p>
        </div>
    </AdminLayout>
</template>

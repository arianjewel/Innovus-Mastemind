<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ categories: Array });

const destroy = (id) => {
    if (confirm('Delete this category? Products in it will become uncategorized.')) {
        router.delete(route('admin.categories.destroy', id), { preserveScroll: true });
    }
};

const toggleActive = (cat) => {
    router.patch(route('admin.categories.update', cat.id), {
        name: cat.name,
        description: cat.description,
        sort_order: cat.sort_order,
        is_active: !cat.is_active,
    }, { preserveScroll: true, only: ['categories', 'flash'] });
};
</script>

<template>
    <Head title="Categories" />

    <AdminLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Product Categories</h1>
                <p class="text-sm text-slate-500">Group products for filtering & navigation.</p>
            </div>
            <Link :href="route('admin.categories.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Category
            </Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="categories.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Slug</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Products</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Order</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="c in categories" :key="c.id" class="hover:bg-slate-50/70">
                        <td class="flex items-center gap-3 px-5 py-3">
                            <img v-if="c.image_path" :src="`/storage/${c.image_path}`" class="h-9 w-9 rounded-lg border border-slate-200 object-cover" />
                            <span class="font-medium text-slate-800">{{ c.name }}</span>
                        </td>
                        <td class="px-5 py-3 font-mono text-xs text-slate-400">{{ c.slug }}</td>
                        <td class="px-5 py-3 text-center tabular-nums text-slate-600">{{ c.products_count }}</td>
                        <td class="px-5 py-3 text-center tabular-nums text-slate-600">{{ c.sort_order }}</td>
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
                            <Link :href="route('admin.categories.edit', c.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(c.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">No categories yet.</p>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    products: Object,
    filters: Object,
});

const search = ref(props.filters.search ?? '');
let debounce;

watch(search, (val) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => apply({ search: val }), 350);
});

const apply = (patch) => {
    router.get(route('admin.products.index'), { ...props.filters, ...patch }, {
        preserveState: true,
        preserveScroll: true,
        only: ['products'],
        replace: true,
    });
};

const destroy = (id) => {
    if (confirm('Delete this product and all its images?')) {
        router.delete(route('admin.products.destroy', id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Products" />

    <AdminLayout>
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Products</h1>
                <p class="text-sm text-slate-500">{{ products.total }} product(s) in catalog.</p>
            </div>
            <div class="flex items-center gap-3">
                <input
                    v-model="search"
                    type="search"
                    placeholder="Search products…"
                    class="w-56 rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                />
                <Link :href="route('admin.products.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    New Product
                </Link>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table v-if="products.data.length" class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Product</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Category / Brand</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Price</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Flags</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="p in products.data" :key="p.id" class="hover:bg-slate-50/70">
                        <td class="flex items-center gap-3 px-5 py-3">
                            <img :src="p.cover_url" class="h-11 w-14 rounded-lg border border-slate-200 bg-slate-100 object-cover" />
                            <div class="min-w-0">
                                <p class="truncate font-medium text-slate-800">{{ p.title }}</p>
                                <p class="truncate text-[11px] text-slate-400">{{ p.sku }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <p class="text-slate-700">{{ p.category_name }}</p>
                            <p class="text-[11px] text-slate-400">{{ p.brand_name }}</p>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right tabular-nums text-slate-700">
                            {{ p.price !== null ? `${p.currency} ${Number(p.price).toLocaleString()}` : '—' }}
                            <span v-if="p.unit" class="block text-[10px] uppercase text-slate-400">per {{ p.unit }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <Link :href="route('admin.products.edit', p.id)" title="Edit to change flags" class="inline-flex items-center gap-1.5">
                                <span class="inline-block h-2.5 w-2.5 rounded-full" :class="p.is_active ? 'bg-green-500' : 'bg-slate-300'"></span>
                                <span v-if="p.is_featured" class="inline-block h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                            </Link>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <Link :href="route('admin.products.edit', p.id)" class="font-medium text-brand-600 hover:text-brand-800">Edit</Link>
                            <button @click="destroy(p.id)" class="ml-4 font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="px-5 py-14 text-center text-sm text-slate-400">
                {{ search ? `No products match "${search}".` : 'No products yet.' }}
            </p>

            <Pagination v-if="products.last_page > 1" :links="products.links" :only="['products']" class="border-t border-slate-100" />
        </div>
    </AdminLayout>
</template>

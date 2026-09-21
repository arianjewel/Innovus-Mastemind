<script setup>
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProductCard from '@/Components/ProductCard.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    products: Object,
    filters: Object,
    categories: Array,
    brands: Array,
});

const search = ref(props.filters.search || '');
const sort = ref(props.filters.sort || 'latest');
const minPrice = ref(props.filters.min_price || '');
const maxPrice = ref(props.filters.max_price || '');

let debounce = null;

const applyFilters = (patch = {}) => {
    router.get('/products', {
        search: search.value || null,
        category: props.filters.category || null,
        brand: props.filters.brand || null,
        sort: sort.value === 'latest' ? null : sort.value,
        min_price: minPrice.value || null,
        max_price: maxPrice.value || null,
        ...patch,
    }, {
        preserveScroll: true,
        preserveState: true,
        only: ['products', 'filters'],
    });
};

watch(search, () => {
    clearTimeout(debounce);
    debounce = setTimeout(() => applyFilters(), 400);
});

watch(sort, () => applyFilters());

const toggleTaxonomy = (key, slug) => {
    const currentSlug = props.filters[key];
    applyFilters({ [key]: currentSlug === slug ? null : slug });
};
</script>

<template>
    <PublicLayout>
        <Head title="Products" />

        <section class="relative bg-navy-900 overflow-hidden">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 80% 30%, #0891b2 0%, transparent 45%)"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Supply Division</p>
                <h1 class="mt-2 text-4xl font-bold text-white">Our Products</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">Quality construction materials, equipment and safety gear. Browse the catalog and request a quote.</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid gap-8 lg:grid-cols-[280px_1fr] items-start">
            <!-- Filters sidebar -->
            <aside class="space-y-6 lg:sticky lg:top-24 w-full">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input
                            v-model="search"
                            type="search"
                            placeholder="Product or SKU…"
                            class="w-full rounded-lg border-slate-200 border pl-9 pr-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                        />
                    </div>

                    <label class="block mt-4 text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Sort By</label>
                    <select
                        v-model="sort"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-brand-500"
                    >
                        <option value="latest">Latest</option>
                        <option value="title">Name A–Z</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>

                    <label class="block mt-4 text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Price Range (BDT)</label>
                    <div class="flex gap-2">
                        <input v-model="minPrice" @change="applyFilters()" type="number" min="0" placeholder="Min" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" />
                        <span class="self-center text-slate-400">–</span>
                        <input v-model="maxPrice" @change="applyFilters()" type="number" min="0" placeholder="Max" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" />
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-3">Categories</h3>
                    <ul class="space-y-1">
                        <li>
                            <button
                                @click="toggleTaxonomy('category', undefined)"
                                class="w-full flex justify-between items-center rounded-lg px-3 py-1.5 text-sm hover:bg-slate-50"
                                :class="!filters.category ? 'bg-brand-50 font-medium text-brand-700' : 'text-slate-600'"
                            >
                                All Categories
                            </button>
                        </li>
                        <li v-for="cat in categories" :key="cat.id">
                            <button
                                @click="toggleTaxonomy('category', cat.slug)"
                                class="w-full flex justify-between items-center rounded-lg px-3 py-1.5 text-sm transition"
                                :class="filters.category === cat.slug ? 'bg-brand-50 font-medium text-brand-700' : 'text-slate-600 hover:bg-slate-50'"
                            >
                                {{ cat.name }}
                                <span class="text-xs text-slate-400">{{ cat.products_count }}</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div v-if="brands.length" class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-3">Brands</h3>
                    <ul class="space-y-1">
                        <li v-for="brand in brands" :key="brand.id">
                            <button
                                @click="toggleTaxonomy('brand', brand.slug)"
                                class="w-full flex justify-between items-center rounded-lg px-3 py-1.5 text-sm transition"
                                :class="filters.brand === brand.slug ? 'bg-brand-50 font-medium text-brand-700' : 'text-slate-600 hover:bg-slate-50'"
                            >
                                {{ brand.name }}
                                <span class="text-xs text-slate-400">{{ brand.products_count }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Product grid -->
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-sm text-slate-500">
                        Showing <strong>{{ products.from ?? 0 }}–{{ products.to ?? 0 }}</strong> of <strong>{{ products.total }}</strong> products
                    </p>
                </div>

                <div v-if="products.data.length" class="grid grid-cols-2 gap-4 md:gap-6 xl:grid-cols-3">
                    <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
                </div>
                <div v-else class="rounded-xl border-2 border-dashed border-slate-200 py-24 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25M12 13.875V7.5M10.5 2.25H13.5A1.5 1.5 0 0115 3.75v1.5h-6v-1.5a1.5 1.5 0 011.5-1.5z"/></svg>
                    <h3 class="mt-3 font-semibold text-slate-700">No products found</h3>
                    <p class="mt-1 text-sm text-slate-500">Try adjusting your filters or search terms.</p>
                </div>

                <Pagination :links="products.links" :only="['products', 'filters']" />
            </div>
        </section>
    </PublicLayout>
</template>

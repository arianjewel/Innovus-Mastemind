<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    product: { type: Object, required: true },
});

const cover = props.product.images?.[0]?.path;
const fmt = (n) => new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(Number(n ?? 0));
</script>

<template>
    <Link
        :href="`/products/${product.slug}`"
        class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex flex-col"
    >
        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
            <img
                v-if="cover"
                :src="`/storage/${cover}`"
                :alt="product.title"
                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
            />
            <div v-else class="h-full w-full grid place-items-center text-slate-400">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A1.5 1.5 0 0021.75 19.5V4.5A1.5 1.5 0 0020.25 3H3.75A1.5 1.5 0 002.25 4.5v15A1.5 1.5 0 003.75 21z"/></svg>
            </div>
        </div>
        <div class="p-4 flex flex-col flex-1">
            <p class="text-xs text-brand-700 font-medium uppercase tracking-wide">
                {{ product.category?.name || 'Product' }}
            </p>
            <h3 class="mt-1 font-semibold text-slate-900 leading-snug line-clamp-2 group-hover:text-brand-700">
                {{ product.title }}
            </h3>
            <p class="text-xs text-slate-500 mt-1">{{ product.brand?.name || 'Generic' }}<span v-if="product.sku"> · SKU: {{ product.sku }}</span></p>
            <div class="mt-auto pt-3 flex items-baseline gap-2">
                <span class="text-lg font-bold text-navy-900">৳ {{ fmt(product.price) }}</span>
                <span class="text-xs text-slate-500">/ {{ product.unit }}</span>
                <span
                    v-if="product.old_price && Number(product.old_price) > Number(product.price)"
                    class="ml-auto text-xs text-slate-400 line-through"
                >৳ {{ fmt(product.old_price) }}</span>
            </div>
        </div>
    </Link>
</template>

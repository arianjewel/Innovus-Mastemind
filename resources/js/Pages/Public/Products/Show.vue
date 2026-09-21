<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    product: Object,
    relatedProducts: Array,
});

const activeImage = computed(() => images.value[selected.value]);
const selected = ref(0);
const images = computed(() =>
    props.product.images?.length
        ? props.product.images.map((img) => img.path)
        : []
);

const specs = computed(() => props.product.specifications ?? []);

/* ---------- Inquiry form ---------- */
const inquiryOpen = ref(false);
const form = useForm({
    name: '',
    phone: '',
    email: '',
    quantity: '',
    message: '',
});

const submitInquiry = () => {
    form.post(`/products/${props.product.slug}/inquiry`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            setTimeout(() => (inquiryOpen.value = false), 1200);
        },
    });
};

const fmt = (n) => new Intl.NumberFormat('en-IN', { maximumFractionDigits: 2 }).format(Number(n ?? 0));
</script>

<template>
    <PublicLayout>
        <Head :title="product.title" />

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20">
            <!-- breadcrumb -->
            <nav class="text-xs text-slate-500 mb-6">
                <Link href="/" class="hover:text-brand-700">Home</Link>
                <span class="mx-1.5">/</span>
                <Link href="/products" class="hover:text-brand-700">Products</Link>
                <template v-if="product.category">
                    <span class="mx-1.5">/</span>
                    <Link :href="`/products?category=${product.category.slug}`" class="hover:text-brand-700">{{ product.category.name }}</Link>
                </template>
            </nav>

            <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_400px] items-start">
                <!-- Gallery -->
                <div>
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <img v-if="activeImage" :src="`/storage/${activeImage}`" :alt="product.title" class="h-full w-full object-cover" />
                        <div v-else class="h-full grid place-items-center text-slate-300">
                            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                        </div>
                    </div>
                    <div v-if="images.length > 1" class="mt-3 flex gap-3 overflow-x-auto pb-1">
                        <button
                            v-for="(img, i) in images"
                            :key="i"
                            @click="selected = i"
                            class="h-20 w-24 shrink-0 overflow-hidden rounded-lg border-2 transition"
                            :class="selected === i ? 'border-brand-600 ring-2 ring-brand-200' : 'border-transparent opacity-70 hover:opacity-100'"
                        >
                            <img :src="`/storage/${img}`" :alt="`${product.title} view ${i + 1}`" class="h-full w-full object-cover" />
                        </button>
                    </div>

                    <!-- Specifications table -->
                    <div v-if="specs.length" class="mt-10">
                        <h2 class="text-xl font-bold text-navy-900 mb-4">Technical Specifications</h2>
                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-slate-100">
                                    <tr v-for="(spec, i) in specs" :key="i" :class="i % 2 === 0 ? 'bg-white' : 'bg-slate-50/60'">
                                        <th class="w-44 px-4 py-3 text-left font-semibold text-slate-700 align-top">{{ spec.label }}</th>
                                        <td class="px-4 py-3 text-slate-600">{{ spec.value }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Details -->
                    <div v-if="product.details" class="mt-10">
                        <h2 class="text-xl font-bold text-navy-900 mb-4">Product Details</h2>
                        <div class="prose-cms" v-html="(product.details || '').split('\n\n').map(p => `<p>${p}</p>`).join('')"></div>
                    </div>
                </div>

                <!-- Info / price panel -->
                <aside class="space-y-5 lg:sticky lg:top-24">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-600">{{ product.category?.name || 'Product' }}</p>
                        <h1 class="mt-1 text-2xl font-bold leading-snug text-navy-900">{{ product.title }}</h1>

                        <div class="mt-2 flex flex-wrap gap-x-4 text-sm text-slate-500">
                            <span>Brand: <strong class="text-slate-800">{{ product.brand?.name || 'Generic' }}</strong></span>
                            <span v-if="product.sku">SKU: <strong class="text-slate-800">{{ product.sku }}</strong></span>
                        </div>

                        <div class="mt-5 flex items-end gap-3 border-t border-slate-100 pt-5">
                            <p class="text-3xl font-bold text-brand-700">৳ {{ fmt(product.price) }}</p>
                            <p class="pb-1 text-sm text-slate-500">/ {{ product.unit }}</p>
                            <p
                                v-if="product.old_price && Number(product.old_price) > Number(product.price)"
                                class="ml-auto pb-1 text-sm text-slate-400 line-through"
                            >
                                ৳ {{ fmt(product.old_price) }}
                            </p>
                        </div>

                        <p v-if="product.short_desc" class="mt-4 text-sm leading-relaxed text-slate-600">{{ product.short_desc }}</p>

                        <button
                            @click="inquiryOpen = !inquiryOpen"
                            class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-brand-600 hover:bg-brand-500 px-6 py-3.5 font-semibold text-white shadow-lg shadow-brand-600/30 transition"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18a3.75 3.75 0 01-3.75 3.75h-7.5A3.75 3.75 0 01.75 18v-7.5A3.75 3.75 0 014.5 6.75h2.25m9.75 9L21 11.25m-4.5-4.5L21 11.25H9"/></svg>
                            Request a Quote
                        </button>

                        <transition enter-active-class="transition duration-200 ease-out" enter-from-class="-translate-y-2 opacity-0">
                            <form v-if="inquiryOpen" @submit.prevent="submitInquiry" class="mt-5 space-y-3 rounded-xl bg-slate-50 p-4 border border-slate-200">
                                <input v-model="form.name" type="text" required placeholder="Your name *" class="w-full rounded-lg border-slate-300 border bg-white px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500" />
                                <div class="grid grid-cols-2 gap-3">
                                    <input v-model="form.phone" type="tel" required placeholder="Phone *" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-brand-500" />
                                    <input v-model="form.quantity" type="text" placeholder="Quantity" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-brand-500" />
                                </div>
                                <input v-model="form.email" type="email" placeholder="Email (optional)" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-brand-500" />
                                <textarea v-model="form.message" rows="3" placeholder="Additional details…" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-brand-500"></textarea>
                                <p v-if="form.errors && Object.keys(form.errors).length" class="text-xs text-red-600">{{ Object.values(form.errors)[0] }}</p>
                                <button type="submit" :disabled="form.processing" class="w-full rounded-lg bg-navy-900 hover:bg-navy-800 disabled:opacity-60 px-4 py-2.5 text-sm font-semibold text-white transition">
                                    {{ form.processing ? 'Submitting…' : 'Submit Request' }}
                                </button>
                            </form>
                        </transition>
                    </div>

                    <div class="rounded-2xl bg-gradient-to-br from-brand-700 to-navy-900 p-6 text-white">
                        <h3 class="font-semibold">Need bulk pricing?</h3>
                        <p class="mt-1 text-sm text-brand-100">We supply projects at scale — contact us for negotiated rates and delivery schedules.</p>
                        <a href="/contact" class="mt-4 inline-block rounded-lg bg-white/10 border border-white/25 px-4 py-2 text-sm font-medium hover:bg-white hover:text-brand-800 transition">Contact Sales Team</a>
                    </div>
                </aside>
            </div>

            <!-- Related products -->
            <div v-if="relatedProducts.length" class="mt-16">
                <h2 class="text-2xl font-bold text-navy-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
                    <ProductCard v-for="rel in relatedProducts" :key="rel.id" :product="rel" />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

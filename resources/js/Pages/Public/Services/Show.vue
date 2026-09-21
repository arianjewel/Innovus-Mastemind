<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    service: Object,
    otherServices: Array,
});
</script>

<template>
    <PublicLayout>
        <Head :title="service.title" />

        <section class="relative bg-navy-900 overflow-hidden">
            <img v-if="service.image_path" :src="`/storage/${service.image_path}`" :alt="service.title" class="absolute inset-0 h-full w-full object-cover opacity-30" />
            <div class="absolute inset-0 bg-gradient-to-r from-navy-950/90 to-navy-900/60"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <nav class="text-xs text-brand-300 mb-3">
                    <Link href="/" class="hover:text-white">Home</Link>
                    <span class="mx-1.5">/</span>
                    <Link href="/services" class="hover:text-white">Services</Link>
                    <span class="mx-1.5">/</span>
                    <span class="text-white">{{ service.title }}</span>
                </nav>
                <h1 class="text-4xl font-bold text-white">{{ service.title }}</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">{{ service.short_desc }}</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-12 lg:grid-cols-[1fr_320px] items-start">
            <article>
                <h2 class="text-xl font-bold text-navy-900 mb-4">Service Overview</h2>
                <div class="prose-cms" v-html="(service.description || '').split('\n\n').map(p => `<p>${p}</p>`).join('')"></div>

                <h2 v-if="service.features?.length" class="mt-10 text-xl font-bold text-navy-900 mb-4">
                    What's Included
                </h2>
                <ul v-if="service.features?.length" class="grid gap-3 sm:grid-cols-2">
                    <li
                        v-for="(feature, i) in service.features"
                        :key="i"
                        class="flex items-start gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 hover:border-brand-300 transition"
                    >
                        <span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full bg-brand-100 text-brand-700">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ feature }}
                    </li>
                </ul>

                <Link href="/contact" class="mt-10 inline-flex items-center gap-2 rounded-lg bg-brand-600 hover:bg-brand-500 px-6 py-3 font-semibold text-white shadow-lg shadow-brand-600/25 transition">
                    Request This Service
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5"/></svg>
                </Link>
            </article>

            <aside class="space-y-4 lg:sticky lg:top-24">
                <div class="rounded-2xl border border-slate-200 p-5 bg-white shadow-sm">
                    <h3 class="font-semibold text-navy-900 mb-3 text-sm uppercase tracking-wide">Other Services</h3>
                    <ul class="space-y-1">
                        <li v-for="other in otherServices" :key="other.id">
                            <Link :href="`/services/${other.slug}`" class="block rounded-lg px-3 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-700 transition">
                                {{ other.title }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </aside>
        </section>
    </PublicLayout>
</template>

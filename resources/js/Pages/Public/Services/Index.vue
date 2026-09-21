<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({
    services: Array,
});
</script>

<template>
    <PublicLayout>
        <Head title="Services" />

        <section class="relative bg-navy-900 overflow-hidden">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 15% 80%, #0891b2 0%, transparent 45%)"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">What We Do</p>
                <h1 class="mt-2 text-4xl font-bold text-white">Our Services</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">Three integrated divisions covering the full project lifecycle — design, build and supply.</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <Link
                v-for="service in services"
                :key="service.id"
                :href="`/services/${service.slug}`"
                class="group rounded-2xl border border-slate-200 overflow-hidden bg-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
            >
                <div class="aspect-[16/10] overflow-hidden">
                    <img
                        v-if="service.image_path"
                        :src="`/storage/${service.image_path}`"
                        :alt="service.title"
                        class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                </div>
                <div class="p-6">
                    <h2 class="text-lg font-bold text-navy-900 group-hover:text-brand-700">{{ service.title }}</h2>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ service.short_desc }}</p>
                    <ul v-if="service.features?.length" class="mt-3 space-y-1">
                        <li v-for="f in service.features.slice(0, 3)" :key="f" class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="text-brand-500">▸</span>{{ f }}
                        </li>
                        <li v-if="service.features.length > 3" class="pl-4 text-xs font-medium text-brand-600">+{{ service.features.length - 3 }} more…</li>
                    </ul>
                </div>
            </Link>
        </section>
    </PublicLayout>
</template>

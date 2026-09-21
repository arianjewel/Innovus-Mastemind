<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProductCard from '@/Components/ProductCard.vue';
import ProjectCard from '@/Components/ProjectCard.vue';

const props = defineProps({
    sliders: Array,
    services: Array,
    featuredProducts: Array,
    featuredProjects: Array,
    clients: Array,
    stats: Object,
});

const current = ref(0);
let timer = null;

const go = (i) => {
    current.value = (i + props.sliders.length) % props.sliders.length;
};
const startAuto = () => {
    timer = setInterval(() => go(current.value + 1), 6000);
};
onMounted(startAuto);
onBeforeUnmount(() => clearInterval(timer));

const icons = {
    building: 'M2.25 21h19.5M5.25 21V5.25A2.25 2.25 0 017.5 3h9a2.25 2.25 0 012.25 2.25V21M9 6.75h1.5M13.5 6.75H15M9 10.5h1.5M13.5 10.5H15M9 14.25h1.5M13.5 14.25H15',
    drafting: 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437',
    truck: 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
};
</script>

<template>
    <PublicLayout>
        <Head title="Home" />

        <!-- ============ HERO SLIDER ============ -->
        <section class="relative h-[68vh] min-h-[480px] max-h-[720px] overflow-hidden bg-navy-900">
            <transition-group
                enter-active-class="transition duration-700 ease-out"
                enter-from-class="opacity-0 scale-105"
                leave-active-class="absolute inset-0 transition duration-700 ease-out"
                leave-to-class="opacity-0 scale-100"
            >
                <div
                    v-for="(slide, i) in sliders"
                    v-show="i === current"
                    :key="slide.id"
                    class="absolute inset-0"
                >
                    <img :src="`/storage/${slide.image_path}`" :alt="slide.title" class="h-full w-full object-cover opacity-60" />
                    <div class="absolute inset-0 bg-gradient-to-r from-navy-950/85 via-navy-950/55 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            <div class="max-w-2xl">
                                <p class="inline-block px-3 py-1 rounded-full bg-brand-600/90 text-white text-xs font-semibold tracking-widest uppercase mb-5">
                                    Innovus Mastermind
                                </p>
                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                                    {{ slide.title }}
                                </h1>
                                <p class="mt-4 text-slate-200 text-base sm:text-lg leading-relaxed line-clamp-3">
                                    {{ slide.subtitle }}
                                </p>
                                <Link
                                    v-if="slide.cta_link"
                                    :href="slide.cta_link"
                                    class="mt-7 inline-flex items-center gap-2 rounded-lg bg-brand-600 hover:bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition"
                                >
                                    {{ slide.cta_text || 'Learn More' }}
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </transition-group>

            <!-- dots -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                <button
                    v-for="(s, i) in sliders"
                    :key="`dot-${s.id}`"
                    @click="go(i); startAuto()"
                    class="h-2.5 rounded-full transition-all duration-300"
                    :class="i === current ? 'w-8 bg-brand-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                    :aria-label="`Slide ${i + 1}`"
                />
            </div>
        </section>

        <!-- ============ STATS BAND ============ -->
        <section class="bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div v-for="(value, key) in stats" :key="key">
                    <p class="text-4xl font-bold text-brand-600">{{ value }}</p>
                    <p class="mt-1 text-sm text-slate-500 capitalize">{{ key.replace('stat_', '').replace(/_/g, ' ') }}</p>
                </div>
            </div>
        </section>

        <!-- ============ SERVICES ============ -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold tracking-widest uppercase text-sm">What We Do</p>
                <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-navy-900">Our Core Services</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <Link
                    v-for="service in services"
                    :key="service.id"
                    :href="`/services/${service.slug}`"
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 p-7 hover:border-brand-300 hover:shadow-xl transition-all duration-300 bg-white"
                >
                    <span class="absolute top-0 right-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors"></span>
                    <span class="relative inline-grid place-items-center h-14 w-14 rounded-xl bg-brand-700 text-white shadow-lg shadow-brand-700/30">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="icons[service.icon] || icons.building"/>
                        </svg>
                    </span>
                    <h3 class="relative mt-5 text-lg font-bold text-navy-900 group-hover:text-brand-700">{{ service.title }}</h3>
                    <p class="relative mt-2 text-sm text-slate-600 leading-relaxed">{{ service.short_desc }}</p>
                    <p class="relative mt-4 text-sm font-semibold text-brand-600 inline-flex items-center gap-1">
                        Details
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5"/></svg>
                    </p>
                </Link>
            </div>
        </section>

        <!-- ============ FEATURED PROJECTS (dark) ============ -->
        <section class="bg-navy-950 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4 mb-12">
                    <div>
                        <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Portfolio</p>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-white">Featured Projects</h2>
                        <p class="mt-2 text-slate-400 max-w-xl">Consultancy, construction and supply engagements for government agencies, NGOs and development partners across Bangladesh.</p>
                    </div>
                    <Link href="/projects" class="rounded-lg border border-brand-500/50 px-5 py-2.5 text-sm font-semibold text-brand-300 hover:bg-brand-600 hover:text-white transition">
                        View All Projects
                    </Link>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <ProjectCard v-for="project in featuredProjects" :key="project.id" :project="project" />
                </div>
            </div>
        </section>

        <!-- ============ FEATURED PRODUCTS ============ -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-12">
                <div>
                    <p class="text-brand-600 font-semibold tracking-widest uppercase text-sm">Supply Division</p>
                    <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-navy-900">Featured Products</h2>
                </div>
                <Link href="/products" class="rounded-lg border border-brand-600 px-5 py-2.5 text-sm font-semibold text-brand-700 hover:bg-brand-600 hover:text-white transition">
                    Browse All Products
                </Link>
            </div>
            <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
                <ProductCard v-for="product in featuredProducts" :key="product.id" :product="product" />
            </div>
        </section>

        <!-- ============ ABOUT PREVIEW ============ -->
        <section class="bg-slate-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid items-center gap-12 lg:grid-cols-2">
                <div class="grid grid-cols-2 gap-4">
                    <img :src="'/storage/services/construction.svg'" alt="Construction" class="rounded-2xl shadow-md aspect-[4/5] object-cover w-full row-span-2" />
                    <img :src="'/storage/services/consultancy.svg'" alt="Consultancy" class="rounded-2xl shadow-md aspect-video object-cover w-full" />
                    <img :src="'/storage/services/supply.svg'" alt="Supply" class="rounded-2xl shadow-md aspect-video object-cover w-full" />
                </div>
                <div>
                    <p class="text-brand-600 font-semibold tracking-widest uppercase text-sm">About Us</p>
                    <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-navy-900 leading-tight">
                        Engineering solutions that improve communities
                    </h2>
                    <p class="mt-5 text-slate-600 leading-relaxed">
                        Since 2021, Innovus Mastermind has delivered infrastructure, water management, structural design
                        and development projects for government organizations, NGOs, private companies and development partners —
                        combining BUET/DUET-grade engineering expertise with practical field experience.
                    </p>
                    <ul class="mt-6 space-y-3">
                        <li v-for="v in ['DPHE-enlisted 1st class contractor', 'In-house hydraulic modelling & GIS capability', 'Experienced consultant panel of PhD experts']" :key="v" class="flex items-start gap-3 text-sm text-slate-700">
                            <span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full bg-green-100 text-green-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            {{ v }}
                        </li>
                    </ul>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <Link href="/about" class="rounded-lg bg-brand-600 hover:bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition">More About Us</Link>
                        <Link href="/contact" class="rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-brand-500 hover:text-brand-700 transition">Get In Touch</Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ CLIENTS ============ -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-center text-sm font-semibold tracking-widest uppercase text-slate-400 mb-8">Trusted By Leading Organizations</p>
            <div class="flex flex-wrap justify-center items-center gap-x-10 gap-y-6">
                <div v-for="client in clients" :key="client.id" class="opacity-80 hover:opacity-100 transition">
                    <img v-if="client.logo_path && !client.logo_path.endsWith('.svg')" :src="`/storage/${client.logo_path}`" :alt="client.name" class="h-12 w-auto" />
                    <template v-else>
                        <img :src="`/storage/${client.logo_path}`" :alt="client.name" class="h-14 w-auto grayscale contrast-75" :title="client.name" />
                    </template>
                </div>
            </div>
        </section>

        <!-- ============ CTA ============ -->
        <section class="relative overflow-hidden bg-gradient-to-br from-brand-800 to-navy-900">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, #22d3ee 0%, transparent 40%), radial-gradient(circle at 80% 70%, #f59e0b 0%, transparent 40%)"></div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 py-20 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">Have a project in mind?</h2>
                <p class="mt-3 text-brand-100 text-lg">Let's discuss how our engineering expertise can bring it to life.</p>
                <Link href="/contact" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-white px-8 py-3.5 font-semibold text-brand-800 shadow-xl hover:bg-brand-50 transition">
                    Request a Quote
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5"/></svg>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>

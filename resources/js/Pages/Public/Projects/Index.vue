<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProjectCard from '@/Components/ProjectCard.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    projects: Object,
    activeType: String,
});

const types = [
    { key: null, label: 'All Projects' },
    { key: 'consultancy', label: 'Consultancy' },
    { key: 'construction', label: 'Construction' },
    { key: 'supply', label: 'Supply' },
];

const setType = (type) => {
    router.get('/projects', type ? { type } : {}, {
        preserveScroll: true,
        only: ['projects', 'activeType'],
    });
};
</script>

<template>
    <PublicLayout>
        <Head title="Projects" />

        <section class="relative bg-navy-900 overflow-hidden">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 20% 25%, #0891b2 0%, transparent 45%)"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Portfolio</p>
                <h1 class="mt-2 text-4xl font-bold text-white">Our Projects</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">A track record of consultancy, construction and supply engagements across Bangladesh.</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Filter tabs -->
            <div class="flex flex-wrap gap-2 mb-8">
                <button
                    v-for="t in types"
                    :key="t.label"
                    @click="setType(t.key)"
                    class="rounded-full px-5 py-2 text-sm font-medium transition border"
                    :class="activeType === t.key
                        ? 'bg-brand-600 border-brand-600 text-white shadow-md shadow-brand-600/30'
                        : 'bg-white border-slate-200 text-slate-600 hover:border-brand-400 hover:text-brand-700'"
                >
                    {{ t.label }}
                </button>
            </div>

            <div v-if="projects.data.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <ProjectCard v-for="project in projects.data" :key="project.id" :project="project" />
            </div>
            <div v-else class="rounded-xl border-2 border-dashed border-slate-200 py-24 text-center">
                <h3 class="font-semibold text-slate-700">No projects available</h3>
                <p class="mt-1 text-sm text-slate-500">Check back soon — new projects are added regularly.</p>
            </div>

            <Pagination :links="projects.links" :only="['projects']" />
        </section>
    </PublicLayout>
</template>

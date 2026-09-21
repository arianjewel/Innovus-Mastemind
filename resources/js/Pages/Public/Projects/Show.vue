<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProjectCard from '@/Components/ProjectCard.vue';

const props = defineProps({
    project: Object,
    relatedProjects: Array,
});

const typeLabels = {
    consultancy: 'Consultancy',
    construction: 'Construction',
    supply: 'Supply',
};

const fmtAmount = (n) => new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(Number(n));

const meta = [
    { label: 'Client', value: props.project.client },
    { label: 'Location', value: props.project.location },
    { label: 'Period', value: props.project.period },
    { label: 'Type', value: typeLabels[props.project.type] },
];
</script>

<template>
    <PublicLayout>
        <Head :title="project.title" />

        <!-- Hero -->
        <section class="relative bg-navy-950">
            <img v-if="project.image_path" :src="`/storage/${project.image_path}`" :alt="project.title" class="absolute inset-0 h-full w-full object-cover opacity-35" />
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/70 to-navy-900/40"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <nav class="text-xs text-brand-300 mb-3">
                    <Link href="/" class="hover:text-white">Home</Link>
                    <span class="mx-1.5">/</span>
                    <Link href="/projects" class="hover:text-white">Projects</Link>
                    <span class="mx-1.5">/</span>
                    <Link :href="`/projects?type=${project.type}`" class="hover:text-white">{{ typeLabels[project.type] }}</Link>
                </nav>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-brand-600 text-white">{{ typeLabels[project.type] }}</span>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold"
                        :class="project.status === 'ongoing' ? 'bg-amber-400 text-amber-950' : 'bg-green-500 text-white'"
                    >
                        {{ project.status === 'ongoing' ? 'Ongoing' : 'Completed' }}
                    </span>
                </div>

                <h1 class="max-w-3xl text-3xl sm:text-4xl font-bold text-white leading-tight">{{ project.title }}</h1>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid gap-10 lg:grid-cols-[1fr_340px] items-start">
            <article>
                <!-- Gallery -->
                <div v-if="(project.gallery?.length || 0) > 1" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-10">
                    <img
                        v-for="(img, i) in project.gallery"
                        :key="i"
                        :src="`/storage/${img}`"
                        :alt="`${project.title} gallery ${i + 1}`"
                        loading="lazy"
                        class="aspect-video w-full rounded-lg object-cover border border-slate-200"
                    />
                </div>

                <!-- Overview -->
                <h2 class="text-xl font-bold text-navy-900">Project Overview</h2>
                <div class="prose-cms mt-3" v-html="(project.overview || '').split('\n\n').map(p => `<p>${p}</p>`).join('')"></div>

                <!-- Scope -->
                <template v-if="project.scope?.length">
                    <h2 id="scope" class="mt-10 text-xl font-bold text-navy-900">Scope of Services</h2>
                    <ul class="mt-4 space-y-2.5">
                        <li
                            v-for="(item, i) in project.scope"
                            :key="i"
                            class="flex items-start gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3"
                        >
                            <span class="mt-0.5 shrink-0 font-bold text-brand-600">•</span>
                            <span class="text-sm text-slate-700">{{ item }}</span>
                        </li>
                    </ul>
                </template>

                <!-- Documents & Drawings -->
                <template v-if="project.documents?.length">
                    <h2 id="documents" class="mt-10 text-xl font-bold text-navy-900">Documents & Drawings</h2>
                    <p class="mt-1 text-sm text-slate-500">Downloadable engineering documents for this project.</p>
                    <ul class="mt-4 space-y-2">
                        <li
                            v-for="doc in project.documents"
                            :key="doc.id"
                            class="flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/60 p-4 hover:border-brand-300 transition"
                        >
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-red-100 text-red-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 12h6m-6 3.75h3.75M6.75 21h10.5A2.25 2.25 0 0019.5 18.75V8.297c0-.596-.237-1.167-.658-1.587l-2.052-2.052a2.25 2.25 0 00-1.587-.658H6.75A2.25 2.25 0 004.5 6.25v12.5A2.25 2.25 0 006.75 21z"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-slate-800 text-sm">{{ doc.title }}</p>
                                <p class="text-xs text-slate-400">PDF · {{ doc.size_for_humans }}</p>
                            </div>
                            <a
                                :href="`/project-documents/${doc.id}/download`"
                                class="shrink-0 inline-flex items-center gap-1.5 rounded-lg bg-navy-900 hover:bg-brand-600 px-4 py-2 text-sm font-medium text-white transition"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                Download
                            </a>
                        </li>
                    </ul>
                </template>
            </article>

            <!-- Meta sidebar -->
            <aside class="space-y-5 lg:sticky lg:top-24">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-400 mb-4">Project Information</h3>
                    <dl class="space-y-3 text-sm">
                        <template v-for="item in meta" :key="item.label">
                            <div v-if="item.value" class="flex flex-col">
                                <dt class="text-xs uppercase tracking-wide text-slate-400">{{ item.label }}</dt>
                                <dd class="font-medium text-slate-800">{{ item.value }}</dd>
                            </div>
                        </template>
                        <div v-if="project.contract_amount" class="flex flex-col border-t border-dashed border-slate-200 pt-3">
                            <dt class="text-xs uppercase tracking-wide text-slate-400">Contract Amount</dt>
                            <dd class="text-lg font-bold text-brand-700">৳ {{ fmtAmount(project.contract_amount) }} BDT</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-brand-700 to-navy-900 p-6 text-white">
                    <h3 class="font-semibold">Similar requirements?</h3>
                    <p class="mt-1 text-sm text-brand-100">Our team can deliver comparable results for your organization.</p>
                    <Link href="/contact" class="mt-4 inline-block rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-800 hover:bg-brand-50 transition">Start a Conversation</Link>
                </div>
            </aside>
        </section>

        <!-- Related projects -->
        <section v-if="relatedProjects.length" class="bg-second bg-navy-900 text-white pb-16 pt-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold mb-6">Related Projects</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    <ProjectCard v-for="rel in relatedProjects" :key="rel.id" :project="rel" />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

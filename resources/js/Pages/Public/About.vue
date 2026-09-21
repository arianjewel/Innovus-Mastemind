<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    about: Object,
    leadership: Array,
    staff: Array,
    consultants: Array,
    services: Array,
});

const nl2list = (text) => (text || '').split('\n').filter(Boolean);
</script>

<template>
    <PublicLayout>
        <Head title="About Us" />

        <!-- Page hero -->
        <section class="relative bg-navy-900 overflow-hidden">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 85% 20%, #0891b2 0%, transparent 45%)"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Who We Are</p>
                <h1 class="mt-2 text-4xl font-bold text-white">About Innovus Mastermind</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">{{ about.about_vision?.slice(0, 140) }}…</p>
            </div>
        </section>

        <!-- Company profile -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-12 lg:grid-cols-[1fr_360px]">
            <div>
                <h2 class="text-2xl font-bold text-navy-900 mb-5">Company Profile</h2>
                <div class="prose-cms">
                    <template v-for="(para, i) in (about.about_intro || '').split('\n\n')" :key="i">
                        <p v-if="!para.startsWith('<strong>')" :class="{ 'font-semibold text-brand-800 text-lg': para.startsWith('<strong>') }" v-html="para"></p>
                        <p v-else class="border-l-4 border-brand-500 pl-4 italic font-medium text-brand-800" v-html="para.replace(/<\/?strong>/g, '')"></p>
                    </template>
                </div>

                <!-- Vision & Mission -->
                <div class="mt-10 grid gap-6 md:grid-cols-2">
                    <div class="rounded-2xl bg-gradient-to-br from-brand-700 to-navy-900 p-7 text-white shadow-lg">
                        <svg class="w-8 h-8 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <h3 class="mt-3 text-xl font-bold">Our Vision</h3>
                        <p class="mt-2 text-sm leading-relaxed text-brand-50/90">{{ about.about_vision }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 p-7 shadow-sm bg-white">
                        <svg class="w-8 h-8 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        <h3 class="mt-3 text-xl font-bold text-navy-900">Our Mission</h3>
                        <ul class="mt-2 space-y-1.5">
                            <li v-for="(m, i) in nl2list(about.about_mission)" :key="i" class="flex gap-2 text-sm text-slate-600">
                                <span class="text-brand-500 mt-0.5">▸</span>{{ m }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Core values -->
                <h2 class="mt-14 text-2xl font-bold text-navy-900">Core Values</h2>
                <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <div
                        v-for="value in about.core_values"
                        :key="value"
                        class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:border-green-300 hover:bg-green-50 transition"
                    >
                        <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full bg-green-100 text-green-700">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ value }}
                    </div>
                </div>

                <!-- Leadership -->
                <h2 id="leadership" class="mt-16 text-2xl font-bold text-navy-900">Leadership</h2>
                <div class="mt-6 space-y-8">
                    <article
                        v-for="person in leadership"
                        :key="person.id"
                        class="grid gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-[200px_1fr]"
                    >
                        <img :src="`/storage/${person.photo_path}`" :alt="person.name" class="w-full aspect-square object-cover rounded-xl" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-brand-600">{{ person.experience }} Experience</p>
                            <h3 class="mt-1 text-xl font-bold text-navy-900">{{ person.name }}</h3>
                            <p class="text-sm font-medium text-brand-700">{{ person.designation }}</p>
                            <p class="mt-2 text-xs text-slate-500"><strong class="text-slate-700">Qualification:</strong> {{ person.qualification }}</p>
                            <p class="mt-1 text-xs text-slate-500"><strong class="text-slate-700">Expertise:</strong> {{ person.expertise }}</p>
                            <div class="prose-cms !text-sm mt-3" v-html="(person.bio || '').split('\n\n').map(p => `<p>${p}</p>`).join('')"></div>
                            <details v-if="person.highlights?.length" class="group mt-3">
                                <summary class="cursor-pointer select-none text-sm font-semibold text-brand-700 hover:text-brand-600">
                                    Key Projects & Contributions ({{ person.highlights.length }})
                                </summary>
                                <ul class="mt-3 space-y-1.5 border-l-2 border-brand-200 pl-4">
                                    <li v-for="h in person.highlights" :key="h" class="text-sm text-slate-600 list-disc marker:text-brand-400 ml-2">{{ h }}</li>
                                </ul>
                            </details>
                        </div>
                    </article>
                </div>

                <!-- Staff -->
                <h2 class="mt-16 text-2xl font-bold text-navy-900">Staff Resources & Expertise</h2>
                <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Qualification</th>
                                <th class="px-4 py-3 hidden md:table-cell">Expertise</th>
                                <th class="px-4 py-3">Experience</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <tr v-for="(member, i) in staff" :key="member.id" class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-400">{{ i + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-navy-900">{{ member.name }}<span class="block text-xs font-normal text-slate-500">{{ member.designation }}</span></td>
                                <td class="px-4 py-3 text-slate-600">{{ member.qualification }}</td>
                                <td class="px-4 py-3 text-slate-600 hidden md:table-cell">{{ member.expertise }}</td>
                                <td class="px-4 py-3 whitespace-nowrap"><span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700">{{ member.experience }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Consultant panel -->
                <h2 class="mt-16 text-2xl font-bold text-navy-900">Project-Based Contractual Consultant Panel</h2>
                <div class="mt-6 space-y-4">
                    <details
                        v-for="person in consultants"
                        :key="person.id"
                        class="group rounded-xl border border-slate-200 bg-white open:shadow-md"
                    >
                        <summary class="flex cursor-pointer items-center gap-4 p-5 select-none hover:bg-slate-50 rounded-xl">
                            <img :src="`/storage/${person.photo_path}`" :alt="person.name" class="h-14 w-14 rounded-full object-cover shrink-0" />
                            <span class="min-w-0 flex-1">
                                <span class="block font-semibold text-navy-900">{{ person.name }}</span>
                                <span class="block text-xs text-slate-500 truncate">{{ person.designation }}</span>
                                <span class="mt-1 inline-block rounded-full bg-brand-50 px-2 py-0.5 text-[11px] font-medium text-brand-700">{{ person.experience }}</span>
                            </span>
                            <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </summary>
                        <div class="border-t border-slate-100 px-5 py-4">
                            <p class="text-xs text-slate-500"><strong class="text-slate-700">Qualification:</strong> {{ person.qualification }}</p>
                            <p class="mt-1 text-xs text-slate-500"><strong class="text-slate-700">Expertise:</strong> {{ person.expertise }}</p>
                            <div v-if="person.bio" class="prose-cms !text-sm mt-3" v-html="(person.bio || '').split('\n\n').map(p => `<p>${p}</p>`).join('')"></div>
                            <details v-if="person.highlights?.length" class="mt-3">
                                <summary class="cursor-pointer text-sm font-semibold text-brand-700">Career Highlights ({{ person.highlights.length }})</summary>
                                <ul class="mt-2 space-y-1 border-l-2 border-brand-200 pl-4">
                                    <li v-for="h in person.highlights" :key="h" class="text-sm text-slate-600 list-disc marker:text-brand-400 ml-2">{{ h }}</li>
                                </ul>
                            </details>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Sidebar: company info -->
            <aside class="space-y-6 lg:sticky lg:top-24 self-start">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-navy-900 mb-4">Company Information</h3>
                    <dl class="space-y-3 text-sm">
                        <div v-for="row in about.company_info" :key="row.label" class="flex flex-col">
                            <dt class="text-xs uppercase tracking-wide text-slate-400">{{ row.label }}</dt>
                            <dd class="font-medium text-slate-800">{{ row.value }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-brand-700 to-navy-900 p-6 text-white shadow-lg">
                    <h3 class="font-bold mb-2">Our E-Brochure</h3>
                    <p class="text-sm text-brand-100">Browse our complete company profile as an interactive flipbook.</p>
                    <a href="/ebrochure" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-800 hover:bg-brand-50 transition">
                        Open Flipbook
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5"/></svg>
                    </a>
                </div>
            </aside>
        </section>
    </PublicLayout>
</template>

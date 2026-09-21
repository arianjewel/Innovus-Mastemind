<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    project: { type: Object, required: true },
});

const typeLabels = {
    consultancy: 'Consultancy',
    construction: 'Construction',
    supply: 'Supply',
};

const fmtAmount = (n) => new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(Number(n));
</script>

<template>
    <Link
        :href="`/projects/${project.slug}`"
        class="group relative rounded-xl overflow-hidden bg-navy-900 shadow-md hover:shadow-xl transition-all duration-300"
    >
        <div class="aspect-[4/3] overflow-hidden">
            <img
                v-if="project.image_path"
                :src="`/storage/${project.image_path}`"
                :alt="project.title"
                class="h-full w-full object-cover opacity-90 group-hover:opacity-70 group-hover:scale-105 transition-all duration-300"
                loading="lazy"
            />
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/40 to-transparent"></div>
        <div class="absolute top-3 left-3 flex gap-2">
            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-brand-600 text-white">
                {{ typeLabels[project.type] || project.type }}
            </span>
            <span
                class="px-2.5 py-1 rounded-full text-[11px] font-semibold"
                :class="project.status === 'ongoing' ? 'bg-amber-400 text-amber-950' : 'bg-green-500 text-white'"
            >
                {{ project.status === 'ongoing' ? 'Ongoing' : 'Completed' }}
            </span>
        </div>
        <div class="absolute bottom-0 inset-x-0 p-5">
            <h3 class="font-semibold text-white leading-snug line-clamp-2">{{ project.title }}</h3>
            <p v-if="project.client" class="mt-1 text-xs text-slate-300 truncate">Client: {{ project.client }}</p>
            <p class="mt-0.5 text-xs text-brand-300 flex items-center gap-2">
                <span v-if="project.location">📍 {{ project.location }}</span>
                <span v-if="project.period" class="text-slate-400">· {{ project.period }}</span>
            </p>
            <p v-if="project.contract_amount" class="mt-1 text-sm font-semibold text-accent-400">
                ৳ {{ fmtAmount(project.contract_amount) }} BDT
            </p>
        </div>
    </Link>
</template>

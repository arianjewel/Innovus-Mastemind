<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ members: Array });

const typeLabels = {
    leadership: 'Leadership',
    staff: 'Staff',
    consultant: 'Consultant',
};

const typeColors = {
    leadership: 'bg-brand-100 text-brand-800',
    staff: 'bg-sky-100 text-sky-700',
    consultant: 'bg-amber-100 text-amber-700',
};

const destroy = (id) => {
    if (confirm('Remove this team member?')) {
        router.delete(route('admin.team-members.destroy', id), { preserveScroll: true });
    }
};

const toggleActive = (m) => {
    router.patch(route('admin.team-members.update', m.id), {
        name: m.name,
        designation: m.designation,
        type: m.type,
        qualification: m.qualification,
        expertise: m.expertise,
        experience: m.experience,
        bio: m.bio,
        highlights: m.highlights ?? [],
        sort_order: m.sort_order,
        is_active: !m.is_active,
    }, { preserveScroll: true, only: ['members', 'flash'] });
};
</script>

<template>
    <Head title="Team Members" />

    <AdminLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Team Members</h1>
                <p class="text-sm text-slate-500">Leadership, staff and consultants shown on the About page.</p>
            </div>
            <Link :href="route('admin.team-members.create')" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Member
            </Link>
        </div>

        <div v-if="members.length" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <article v-for="m in members" :key="m.id" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
                <img
                    :src="m.photo_path ? `/storage/${m.photo_path}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(m.name)}&background=0e7490&color=fff`"
                    class="h-16 w-16 shrink-0 rounded-xl object-cover"
                />
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <h3 class="truncate text-sm font-semibold text-navy-900">{{ m.name }}</h3>
                            <p class="truncate text-xs text-slate-500">{{ m.designation || '—' }}</p>
                        </div>
                        <span :class="typeColors[m.type]" class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase">{{ typeLabels[m.type] }}</span>
                    </div>
                    <p v-if="m.experience" class="mt-1 text-[11px] text-slate-400">{{ m.experience }}</p>
                    <div class="mt-2 flex items-center gap-3 text-xs font-medium">
                        <button @click="toggleActive(m)" :class="m.is_active ? 'text-green-600' : 'text-slate-400'" class="hover:underline">
                            {{ m.is_active ? '● Live' : '○ Hidden' }}
                        </button>
                        <Link :href="route('admin.team-members.edit', m.id)" class="text-brand-600 hover:text-brand-800">Edit</Link>
                        <button @click="destroy(m.id)" class="text-red-500 hover:text-red-700">Delete</button>
                    </div>
                </div>
            </article>
        </div>
        <p v-else class="rounded-2xl border border-dashed border-slate-300 py-16 text-center text-sm text-slate-400">No team members yet.</p>
    </AdminLayout>
</template>

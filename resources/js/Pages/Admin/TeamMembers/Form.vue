<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import FileInput from '@/Components/Admin/FileInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';
import SelectInput from '@/Components/Admin/SelectInput.vue';
import ListRepeater from '@/Components/Admin/ListRepeater.vue';

const props = defineProps({
    member: { type: Object, default: null },
});

const isEdit = Boolean(props.member);

const form = useForm({
    name: props.member?.name ?? '',
    designation: props.member?.designation ?? '',
    type: props.member?.type ?? 'staff',
    qualification: props.member?.qualification ?? '',
    expertise: props.member?.expertise ?? '',
    experience: props.member?.experience ?? '',
    bio: props.member?.bio ?? '',
    highlights: props.member?.highlights?.length ? [...props.member.highlights] : [],
    sort_order: props.member?.sort_order ?? 0,
    is_active: props.member?.is_active ?? true,
    photo: null,
});

const typeOptions = [
    { value: 'leadership', label: 'Leadership' },
    { value: 'staff', label: 'Staff' },
    { value: 'consultant', label: 'Consultant' },
];

const submit = () => {
    if (isEdit) {
        form.put(route('admin.team-members.update', props.member.id), {
            preserveScroll: true,
            onSuccess: () => form.reset('photo'),
        });
    } else {
        form.post(route('admin.team-members.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Member' : 'New Member'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.team-members.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Team Members</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? `Edit ${member.name}` : 'New Team Member' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-3xl space-y-6">
            <section class="grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-[220px_1fr]">
                <div>
                    <FileInput v-model="form.photo" label="Photo" hint="Square portrait, ≥400×400" :error="form.errors.photo" />
                    <img
                        v-if="isEdit && !form.photo && member.photo_path"
                        :src="`/storage/${member.photo_path}`"
                        class="mt-4 h-32 w-32 rounded-xl border border-slate-200 object-cover"
                    />
                </div>
                <div class="space-y-4">
                    <TextInput v-model="form.name" label="Full Name" required :error="form.errors.name" />
                    <TextInput v-model="form.designation" label="Designation" :error="form.errors.designation" placeholder="e.g. Managing Director" />
                    <SelectInput v-model="form.type" label="Type" :options="typeOptions" :error="form.errors.type" />
                    <TextInput v-model="form.experience" label="Experience" :error="form.errors.experience" placeholder="e.g. 18+ years" />
                </div>
            </section>

            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextArea v-model="form.bio" label="Bio (leadership)" rows="4" hint="Short biography shown in leadership section" />
                <TextInput v-model="form.expertise" label="Expertise (consultants)" hint="Comma-separated areas of expertise" />
                <ListRepeater v-model="form.highlights" label="Highlights / Key Achievements" add-label="Add Highlight" />
            </section>

            <section class="flex items-center gap-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" class="w-40" />
                <Toggle v-model="form.is_active" label="Active (visible publicly)" />
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Member' : 'Add Member' }}
                </button>
                <Link :href="route('admin.team-members.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

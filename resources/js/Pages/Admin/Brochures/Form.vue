<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import Toggle from '@/Components/Admin/Toggle.vue';

const props = defineProps({
    brochure: { type: Object, default: null },
});

const isEdit = Boolean(props.brochure);

const form = useForm({
    title: props.brochure?.title ?? '',
    description: props.brochure?.description ?? '',
    is_active: isEdit ? (props.brochure?.is_active ?? false) : true,
    pdf: null,
});

const fileName = ref('');

const onPdfPick = (e) => {
    form.pdf = e.target.files[0] ?? null;
    fileName.value = e.target.files[0]?.name ?? '';
};

const submit = () => {
    if (isEdit) {
        form.post(route('admin.brochures.update', props.brochure.id), {
            preserveScroll: true,
        });
    } else {
        form.post(route('admin.brochures.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Brochure' : 'Upload Brochure'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.brochures.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to E-Brochure</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? 'Edit Brochure' : 'Upload Brochure' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-2xl space-y-6">
            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.title" label="Title" required :error="form.errors.title" placeholder="e.g. Innovus Mastermind — Company Profile 2026" />
                <TextArea v-model="form.description" label="Description" rows="3" hint="Shown under the flipbook header" :error="form.errors.description" />
                <Toggle v-model="form.is_active" label="Publish to /ebrochure" hint="Only one brochure can be published at a time." />
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <label class="mb-1 block text-xs font-semibold text-slate-600">
                    PDF File {{ isEdit ? '(leave empty to keep current)' : '*' }}
                </label>
                <input
                    type="file"
                    accept="application/pdf"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-700 hover:file:bg-brand-100"
                    @change="onPdfPick"
                />
                <p v-if="fileName" class="mt-2 text-xs font-medium text-brand-700">Selected: {{ fileName }}</p>
                <p v-if="isEdit && !fileName && brochure.pdf_path" class="mt-3 flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2 text-xs text-slate-500">
                    <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25"/></svg>
                    Current: {{ brochure.title }} · {{ Math.round((brochure.size_bytes || 0) / 1024) }} KB
                </p>
                <p class="mt-2 text-[11px] text-slate-400">Max 20MB · every page is rendered client-side in the flipbook.</p>
                <p v-if="form.errors.pdf" class="mt-1 text-xs font-medium text-red-600">{{ form.errors.pdf }}</p>
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Brochure' : 'Upload Brochure' }}
                </button>
                <Link :href="route('admin.brochures.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

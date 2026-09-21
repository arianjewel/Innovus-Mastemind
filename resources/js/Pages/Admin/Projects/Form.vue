<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import SelectInput from '@/Components/Admin/SelectInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';
import ListRepeater from '@/Components/Admin/ListRepeater.vue';
import FileInput from '@/Components/Admin/FileInput.vue';

const props = defineProps({
    project: { type: Object, default: null },
});

const isEdit = Boolean(props.project);

const form = useForm({
    title: props.project?.title ?? '',
    type: props.project?.type ?? 'construction',
    client: props.project?.client ?? '',
    location: props.project?.location ?? '',
    period: props.project?.period ?? '',
    contract_amount: props.project?.contract_amount ?? '',
    status: props.project?.status ?? 'completed',
    overview: props.project?.overview ?? '',
    scope: props.project?.scope?.length ? [...props.project.scope] : [],
    existing_gallery: props.project?.gallery ? [...props.project.gallery] : [],
    is_featured: props.project?.is_featured ?? false,
    is_active: props.project?.is_active ?? true,
    sort_order: props.project?.sort_order ?? 0,
    image: null,
    gallery_files: null,
    documents: null,
});

const typeOptions = [
    { value: 'consultancy', label: 'Consultancy' },
    { value: 'construction', label: 'Construction' },
    { value: 'supply', label: 'Supply' },
];

const statusOptions = [
    { value: 'ongoing', label: 'Ongoing' },
    { value: 'completed', label: 'Completed' },
];

/* local staged picks */
const docNames = ref([]);

const onGalleryPick = (e) => {
    form.gallery_files = e.target.files;
};
const onDocsPick = (e) => {
    form.documents = e.target.files;
    docNames.value = Array.from(e.target.files || []).map((f) => f.name);
};

const submit = () => {
    const options = { preserveScroll: true };
    if (isEdit) {
        form.put(route('admin.projects.update', props.project.id), options);
    } else {
        form.post(route('admin.projects.store'), options);
    }
};

const removeGalleryImage = (path) => {
    if (!confirm('Remove this gallery image?')) return;
    form.existing_gallery = form.existing_gallery.filter((p) => p !== path);
};

const removeDocument = (docId) => {
    if (!confirm('Delete this document permanently?')) return;
    router.delete(route('project-documents.destroy', docId), { preserveScroll: true });
};

const fmtSize = (bytes) => {
    let b = bytes || 0;
    const units = ['B', 'KB', 'MB'];
    let i = 0;
    while (b >= 1024 && i < units.length - 1) { b /= 1024; i++; }
    return `${b.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
};
</script>

<template>
    <Head :title="isEdit ? `Edit ${project.title}` : 'New Project'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.projects.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Projects</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? project.title : 'New Project' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="grid max-w-6xl items-start gap-6 xl:grid-cols-[1fr_340px]">
            <div class="space-y-6">
                <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <TextInput v-model="form.title" label="Project Title" required :error="form.errors.title" />
                    <div class="grid gap-4 sm:grid-cols-2">
                        <SelectInput v-model="form.type" label="Type" required :options="typeOptions" :error="form.errors.type" />
                        <SelectInput v-model="form.status" label="Status" required :options="statusOptions" :error="form.errors.status" />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <TextInput v-model="form.client" label="Client" :error="form.errors.client" placeholder="e.g. UNHCR / IOM" />
                        <TextInput v-model="form.location" label="Location" :error="form.errors.location" placeholder="e.g. Cox's Bazar" />
                        <TextInput v-model="form.period" label="Period" :error="form.errors.period" placeholder="e.g. Jan 2023 – Dec 2024" />
                    </div>
                    <TextInput v-model="form.contract_amount" label="Contract Amount (BDT)" type="number" step="0.01" min="0" :error="form.errors.contract_amount" />
                    <TextArea v-model="form.overview" label="Overview" rows="6" hint="Paragraphs separated by a blank line" :error="form.errors.overview" />
                    <ListRepeater v-model="form.scope" label="Scope of Services (bullet points)" add-label="Add Scope Item" placeholder="e.g. Detailed engineering design of CAMP shelters" />
                </section>

                <!-- Gallery -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-1 text-sm font-bold text-navy-900">Gallery Images</h2>
                    <p class="mb-4 text-xs text-slate-400">Shown under the project overview. Removed images are deleted only after saving.</p>

                    <div v-if="form.existing_gallery.length" class="mb-5 grid grid-cols-3 gap-3 sm:grid-cols-4">
                        <figure v-for="(path, i) in form.existing_gallery" :key="path" class="group relative overflow-hidden rounded-xl border border-slate-200">
                            <img :src="`/storage/${path}`" class="aspect-[4/3] w-full object-cover" />
                            <button
                                type="button"
                                @click="removeGalleryImage(path)"
                                class="absolute right-1.5 top-1.5 rounded-full bg-red-500/90 p-1 text-white opacity-0 transition group-hover:opacity-100"
                                aria-label="Remove"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            <span v-if="i === 0" class="absolute left-2 top-2 rounded bg-brand-600 px-1.5 py-0.5 text-[9px] font-bold uppercase text-white">Cover*</span>
                        </figure>
                    </div>

                    <input
                        type="file"
                        accept="image/*"
                        multiple
                        class="block w-full text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-700 hover:file:bg-brand-100"
                        @change="onGalleryPick"
                    />
                    <p class="mt-1 text-[11px] text-slate-400">* If no dedicated cover image is set, the first gallery image is used as the card cover.</p>
                </section>

                <!-- Documents -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-1 text-sm font-bold text-navy-900">Documents & Drawings (PDF)</h2>
                    <p class="mb-4 text-xs text-slate-400">Publicly downloadable files listed on the project page.</p>

                    <ul v-if="project?.documents?.length" class="mb-5 space-y-2">
                        <li v-for="doc in project.documents" :key="doc.id" class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-2.5">
                            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span class="min-w-0 flex-1 truncate text-sm text-slate-700">{{ doc.title }}</span>
                            <span class="shrink-0 text-[11px] text-slate-400">{{ fmtSize(doc.size_bytes) }}</span>
                            <a :href="`/storage/${doc.file_path}`" target="_blank" rel="noopener" class="shrink-0 text-xs font-medium text-brand-600 hover:text-brand-800">View</a>
                            <button type="button" @click="removeDocument(doc.id)" class="shrink-0 text-xs font-medium text-red-500 hover:text-red-700">Delete</button>
                        </li>
                    </ul>

                    <input
                        type="file"
                        accept="application/pdf"
                        multiple
                        class="block w-full text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-700 hover:file:bg-brand-100"
                        @change="onDocsPick"
                    />
                    <ul v-if="docNames.length" class="mt-3 space-y-1">
                        <li v-for="(n, i) in docNames" :key="i" class="text-xs text-slate-500">+ {{ n }}</li>
                    </ul>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <section class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-navy-900">Cover Image</h2>
                    <FileInput v-model="form.image" hint="JPG/PNG/WebP · recommended 1600×900" :error="form.errors.image" />
                    <img v-if="isEdit && !form.image && project.image_path" :src="`/storage/${project.image_path}`" class="aspect-video w-full rounded-xl border border-slate-200 object-cover" />
                </section>

                <section class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-navy-900">Visibility</h2>
                    <Toggle v-model="form.is_featured" label="Featured on homepage" />
                    <Toggle v-model="form.is_active" label="Active (visible publicly)" />
                    <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" />
                </section>

                <button type="submit" :disabled="form.processing" class="w-full rounded-lg bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Project' : 'Create Project' }}
                </button>
                <Link :href="route('admin.projects.index')" class="block text-center text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

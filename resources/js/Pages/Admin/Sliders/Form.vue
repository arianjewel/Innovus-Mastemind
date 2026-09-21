<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import FileInput from '@/Components/Admin/FileInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';

const props = defineProps({
    slider: { type: Object, default: null },
});

const isEdit = Boolean(props.slider);

const form = useForm({
    title: props.slider?.title ?? '',
    subtitle: props.slider?.subtitle ?? '',
    cta_text: props.slider?.cta_text ?? '',
    cta_link: props.slider?.cta_link ?? '',
    sort_order: props.slider?.sort_order ?? 0,
    is_active: props.slider?.is_active ?? true,
    image: null,
});

const submit = () => {
    if (isEdit) {
        form.post(route('admin.sliders.update', props.slider.id), {
            preserveScroll: true,
            onSuccess: () => form.reset('image'),
        });
    } else {
        form.post(route('admin.sliders.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Slide' : 'New Slide'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.sliders.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Sliders</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? 'Edit Slide' : 'New Slide' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-3xl space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <FileInput
                    v-model="form.image"
                    label="Background Image *"
                    hint="JPG/PNG/WebP · recommended 1920×900 · max 4MB"
                    :error="form.errors.image"
                />
                <img v-if="isEdit && !form.image && slider.image_path" :src="`/storage/${slider.image_path}`" class="mt-4 h-32 w-full rounded-xl border border-slate-200 object-cover" />
            </section>

            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.title" label="Title" required :error="form.errors.title" placeholder="e.g. Engineering Excellence Since 2012" />
                <TextArea v-model="form.subtitle" label="Subtitle" rows="2" :error="form.errors.subtitle" />
                <div class="grid gap-4 sm:grid-cols-2">
                    <TextInput v-model="form.cta_text" label="Button Text" :error="form.errors.cta_text" placeholder="e.g. Explore Services" />
                    <TextInput v-model="form.cta_link" label="Button Link" :error="form.errors.cta_link" placeholder="/services" />
                </div>
                <div class="grid gap-4 sm:grid-cols-2 sm:items-end">
                    <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" :error="form.errors.sort_order" />
                    <Toggle v-model="form.is_active" label="Active (visible on homepage)" :error="form.errors.is_active" />
                </div>
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Slide' : 'Create Slide' }}
                </button>
                <Link :href="route('admin.sliders.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

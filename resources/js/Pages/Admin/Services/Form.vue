<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import FileInput from '@/Components/Admin/FileInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';
import ListRepeater from '@/Components/Admin/ListRepeater.vue';

const props = defineProps({
    service: { type: Object, default: null },
});

const isEdit = Boolean(props.service);

const form = useForm({
    title: props.service?.title ?? '',
    icon: props.service?.icon ?? '',
    short_desc: props.service?.short_desc ?? '',
    description: props.service?.description ?? '',
    features: props.service?.features?.length ? [...props.service.features] : [],
    sort_order: props.service?.sort_order ?? 0,
    is_active: props.service?.is_active ?? true,
    image: null,
});

const submit = () => {
    if (isEdit) {
        form.post(route('admin.services.update', props.service.id), {
            preserveScroll: true,
            onSuccess: () => form.reset('image'),
        });
    } else {
        form.post(route('admin.services.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Service' : 'New Service'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.services.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Services</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? 'Edit Service' : 'New Service' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-3xl space-y-6">
            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.title" label="Title" required :error="form.errors.title" placeholder="e.g. Engineering Consultancy" />
                <div class="grid gap-4 sm:grid-cols-[1fr_140px]">
                    <TextInput v-model="form.icon" label="Icon Keyword" hint="e.g. blueprint, crane, helmet — used to pick a card icon" :error="form.errors.icon" />
                    <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" :error="form.errors.sort_order" />
                </div>
                <TextArea v-model="form.short_desc" label="Short Description" rows="2" hint="Shown on homepage service cards" :error="form.errors.short_desc" />
                <TextArea v-model="form.description" label="Full Description" rows="7" hint="Paragraphs separated by a blank line; shown on the service detail page" :error="form.errors.description" />
                <ListRepeater v-model="form.features" label="Features / Bullet Points" placeholder="e.g. Feasibility studies & detailed design" add-label="Add Feature" />
            </section>

            <section class="grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-[1fr_220px]">
                <FileInput v-model="form.image" label="Card Image (optional)" hint="JPG/PNG/WebP · recommended 800×500" :error="form.errors.image" />
                <div class="flex flex-col justify-between">
                    <img v-if="isEdit && !form.image && service.image_path" :src="`/storage/${service.image_path}`" class="h-28 rounded-xl border border-slate-200 object-cover" />
                    <Toggle v-model="form.is_active" label="Active (visible publicly)" />
                </div>
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Service' : 'Create Service' }}
                </button>
                <Link :href="route('admin.services.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

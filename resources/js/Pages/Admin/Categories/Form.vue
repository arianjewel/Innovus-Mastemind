<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import FileInput from '@/Components/Admin/FileInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';

const props = defineProps({
    category: { type: Object, default: null },
});

const isEdit = Boolean(props.category);

const form = useForm({
    name: props.category?.name ?? '',
    description: props.category?.description ?? '',
    sort_order: props.category?.sort_order ?? 0,
    is_active: props.category?.is_active ?? true,
    image: null,
});

const submit = () => {
    if (isEdit) {
        form.put(route('admin.categories.update', props.category.id), {
            preserveScroll: true,
            onSuccess: () => form.reset('image'),
        });
    } else {
        form.post(route('admin.categories.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Category' : 'New Category'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.categories.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Categories</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? 'Edit Category' : 'New Category' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-2xl space-y-6">
            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.name" label="Name" required :error="form.errors.name" placeholder="e.g. Construction Machinery" />
                <TextArea v-model="form.description" label="Description" rows="3" :error="form.errors.description" />
                <div class="grid gap-4 sm:grid-cols-[140px_1fr] sm:items-start">
                    <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" :error="form.errors.sort_order" />
                    <Toggle v-model="form.is_active" label="Active (visible publicly)" class="sm:mt-7" />
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <FileInput v-model="form.image" label="Image (optional)" hint="JPG/PNG/WebP · recommended 800×500" :error="form.errors.image" />
                <img v-if="isEdit && !form.image && category.image_path" :src="`/storage/${category.image_path}`" class="mt-4 h-28 rounded-xl border border-slate-200 object-cover" />
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Category' : 'Create Category' }}
                </button>
                <Link :href="route('admin.categories.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

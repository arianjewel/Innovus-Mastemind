<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import FileInput from '@/Components/Admin/FileInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';

const props = defineProps({
    client: { type: Object, default: null },
});

const isEdit = Boolean(props.client);

const form = useForm({
    name: props.client?.name ?? '',
    website: props.client?.website ?? '',
    sort_order: props.client?.sort_order ?? 0,
    is_active: props.client?.is_active ?? true,
    logo: null,
});

const submit = () => {
    if (isEdit) {
        form.put(route('admin.clients.update', props.client.id), {
            preserveScroll: true,
            onSuccess: () => form.reset('logo'),
        });
    } else {
        form.post(route('admin.clients.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Client' : 'New Client'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.clients.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Clients</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? 'Edit Client' : 'New Client' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl space-y-6">
            <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextInput v-model="form.name" label="Name" required :error="form.errors.name" />
                <TextInput v-model="form.website" label="Website" type="url" :error="form.errors.website" placeholder="https://…" />
                <div class="flex items-center gap-8">
                    <TextInput v-model="form.sort_order" label="Sort Order" type="number" min="0" class="w-40" />
                    <Toggle v-model="form.is_active" label="Active" />
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <FileInput v-model="form.logo" label="Logo (optional)" hint="PNG/SVG with transparent background works best" accept="image/*" :error="form.errors.logo" />
                <img v-if="isEdit && !form.logo && client.logo_path" :src="`/storage/${client.logo_path}`" class="mt-4 h-20 w-40 rounded-xl border border-slate-200 bg-white object-contain p-2" />
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Client' : 'Add Client' }}
                </button>
                <Link :href="route('admin.clients.index')" class="text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

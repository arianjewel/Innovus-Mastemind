<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    contact: Object,
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post('/contact', { preserveScroll: true, onSuccess: () => form.reset() });
};
</script>

<template>
    <PublicLayout>
        <Head title="Contact Us" />

        <section class="relative bg-navy-900 overflow-hidden">
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 70% 70%, #0891b2 0%, transparent 45%)"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Get In Touch</p>
                <h1 class="mt-2 text-4xl font-bold text-white">Contact Us</h1>
                <p class="mt-3 text-slate-300 max-w-2xl">Questions about a project, product or partnership? We'd love to hear from you.</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid gap-10 lg:grid-cols-[380px_1fr] items-start">
            <!-- Info cards -->
            <div class="space-y-4">
                <div v-if="contact.address" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-50 text-brand-700 text-xl">📍</span>
                    <div>
                        <h3 class="font-semibold text-navy-900 text-sm">Office Address</h3>
                        <p class="mt-1 text-sm text-slate-600 leading-relaxed">{{ contact.address }}</p>
                    </div>
                </div>

                <div v-if="contact.phone_primary" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-50 text-brand-700 text-xl">📞</span>
                    <div>
                        <h3 class="font-semibold text-navy-900 text-sm">Phone</h3>
                        <a :href="`tel:${contact.phone_primary}`" class="block mt-1 text-sm text-slate-600 hover:text-brand-700">{{ contact.phone_primary }}</a>
                        <a v-if="contact.phone_secondary" :href="`tel:${contact.phone_secondary}`" class="block text-sm text-slate-600 hover:text-brand-700">{{ contact.phone_secondary }}</a>
                    </div>
                </div>

                <div v-if="contact.email_primary" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-50 text-brand-700 text-xl">✉️</span>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-navy-900 text-sm">Email</h3>
                        <a :href="`mailto:${contact.email_primary}`" class="block mt-1 text-sm text-slate-600 hover:text-brand-700 break-all">{{ contact.email_primary }}</a>
                        <a v-if="contact.email_secondary" :href="`mailto:${contact.email_secondary}`" class="block text-sm text-slate-600 hover:text-brand-700 break-all">{{ contact.email_secondary }}</a>
                    </div>
                </div>

                <div v-if="contact.office_hours" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-50 text-brand-700 text-xl">🕐</span>
                    <div>
                        <h3 class="font-semibold text-navy-900 text-sm">Office Hours</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ contact.office_hours }}</p>
                    </div>
                </div>
            </div>

            <!-- Form + map -->
            <div class="space-y-8">
                <form @submit.prevent="submit" class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
                    <h2 class="text-lg font-bold text-navy-900 mb-5">Send us a message</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium text-slate-500">Name *</label>
                            <input v-model="form.name" type="text" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none" />
                            <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-slate-500">Phone</label>
                            <input v-model="form.phone" type="tel" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none" />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-slate-500">Email</label>
                            <input v-model="form.email" type="email" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none" />
                            <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-slate-500">Subject</label>
                            <input v-model="form.subject" type="text" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-1 block text-xs font-medium text-slate-500">Message *</label>
                        <textarea v-model="form.message" rows="5" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none"></textarea>
                        <p v-if="form.errors.message" class="mt-1 text-xs text-red-600">{{ form.errors.message }}</p>
                    </div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-brand-600 hover:bg-brand-500 disabled:opacity-60 px-8 py-3 font-semibold text-white shadow-lg shadow-brand-600/25 transition"
                    >
                        {{ form.processing ? 'Sending…' : 'Send Message' }}
                    </button>
                </form>

                <div v-if="contact.map_embed_url" class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <iframe :src="contact.map_embed_url" width="100%" height="340" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

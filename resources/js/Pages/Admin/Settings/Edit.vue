<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';

const props = defineProps({
    settings: Object,
});

const s = props.settings;

const form = useForm({
    site_name: s.site_name ?? '',
    tagline: s.tagline ?? '',
    address: s.address ?? '',
    phone_primary: s.phone_primary ?? '',
    phone_secondary: s.phone_secondary ?? '',
    email_primary: s.email_primary ?? '',
    email_secondary: s.email_secondary ?? '',
    office_hours: s.office_hours ?? '',
    map_embed_url: s.map_embed_url ?? '',
    facebook_url: s.facebook_url ?? '',
    linkedin_url: s.linkedin_url ?? '',
    youtube_url: s.youtube_url ?? '',
    whatsapp_number: s.whatsapp_number ?? '',
    footer_text: s.footer_text ?? '',
    about_intro: s.about_intro ?? '',
    about_vision: s.about_vision ?? '',
    about_mission: s.about_mission ?? '',
    core_values: (s.core_values ?? []).map((v) => v),
    company_info: (s.company_info ?? []).length
        ? s.company_info.map((r) => ({ label: r.label, value: r.value }))
        : [{ label: '', value: '' }],
    stat_years_experience: s.stat_years_experience ?? '',
    stat_projects_completed: s.stat_projects_completed ?? '',
    stat_experts: s.stat_experts ?? '',
    stat_happy_clients: s.stat_happy_clients ?? '',
    logo: null,
});

const logoName = ref('');

const addValue = () => {
    if (!String(form.core_values.at(-1) ?? '').trim()) return;
    form.core_values.push('');
};
const removeValue = (i) => form.core_values.splice(i, 1);

const addInfo = () => {
    const last = form.company_info.at(-1);
    if (!last || !String(last.label).trim()) return;
    form.company_info.push({ label: '', value: '' });
};
const removeInfo = (i) => form.company_info.splice(i, 1);

const submit = () => {
    form.put(route('admin.settings.update'), { preserveScroll: true });
};

const tabs = ['General', 'Contact', 'About Page', 'Homepage Stats'];
const activeTab = ref('General');
</script>

<template>
    <Head title="Site Settings" />

    <AdminLayout>
        <div class="mb-6">
            <h1 class="text-xl font-bold text-navy-900">Site Settings</h1>
            <p class="text-sm text-slate-500">Global content used across the website.</p>
        </div>

        <!-- Tabs -->
        <div class="mb-5 flex flex-wrap gap-1 rounded-xl border border-slate-200 bg-white p-1 shadow-sm sm:w-fit">
            <button
                v-for="t in tabs"
                :key="t"
                type="button"
                @click="activeTab = t"
                class="rounded-lg px-4 py-2 text-xs font-semibold transition"
                :class="activeTab === t ? 'bg-brand-600 text-white shadow' : 'text-slate-500 hover:bg-slate-100'"
            >
                {{ t }}
            </button>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-3xl space-y-6">
            <!-- General -->
            <section v-show="activeTab === 'General'" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="grid gap-4 sm:grid-cols-2">
                    <TextInput v-model="form.site_name" label="Site Name" required :error="form.errors.site_name" />
                    <TextInput v-model="form.tagline" label="Tagline" :error="form.errors.tagline" placeholder="e.g. Building Tomorrow, Today" />
                </div>
                <TextArea v-model="form.footer_text" label="Footer Text" rows="2" :error="form.errors.footer_text" />

                <label class="block text-xs font-semibold text-slate-600">Logo</label>
                <input
                    type="file"
                    accept="image/png,image/jpeg,image/svg+xml,image/webp"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-700 hover:file:bg-brand-100"
                    @change="(e) => { form.logo = e.target.files[0] ?? null; logoName = e.target.files[0]?.name ?? ''; }"
                />
                <img v-if="s.logo_path && !form.logo" :src="`/storage/${s.logo_path}`" class="h-12 w-auto rounded-lg border border-slate-200 bg-white object-contain p-1" />
                <p v-if="logoName" class="text-xs font-medium text-brand-700">Selected: {{ logoName }}</p>
                <p v-if="form.errors.logo" class="text-xs font-medium text-red-600">{{ form.errors.logo }}</p>
            </section>

            <!-- Contact -->
            <section v-show="activeTab === 'Contact'" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextArea v-model="form.address" label="Office Address" rows="2" :error="form.errors.address" />
                <div class="grid gap-4 sm:grid-cols-2">
                    <TextInput v-model="form.phone_primary" label="Phone (primary)" :error="form.errors.phone_primary" />
                    <TextInput v-model="form.phone_secondary" label="Phone (secondary)" :error="form.errors.phone_secondary" />
                    <TextInput v-model="form.email_primary" label="Email (primary)" :error="form.errors.email_primary" />
                    <TextInput v-model="form.email_secondary" label="Email (secondary)" :error="form.errors.email_secondary" />
                    <TextInput v-model="form.office_hours" label="Office Hours" :error="form.errors.office_hours" placeholder="e.g. Sat–Thu, 9:00 AM – 6:00 PM" />
                    <TextInput v-model="form.whatsapp_number" label="WhatsApp Number" :error="form.errors.whatsapp_number" />
                </div>
                <TextInput v-model="form.map_embed_url" label="Google Maps Embed URL" hint="From Google Maps → Share → Embed a map → copy the src URL" :error="form.errors.map_embed_url" />
                <hr class="border-dashed border-slate-200" />
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Social Links</p>
                <div class="grid gap-4 sm:grid-cols-3">
                    <TextInput v-model="form.facebook_url" label="Facebook" :error="form.errors.facebook_url" />
                    <TextInput v-model="form.linkedin_url" label="LinkedIn" :error="form.errors.linkedin_url" />
                    <TextInput v-model="form.youtube_url" label="YouTube" :error="form.errors.youtube_url" />
                </div>
            </section>

            <!-- About -->
            <section v-show="activeTab === 'About Page'" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <TextArea v-model="form.about_intro" label="Company Introduction" rows="5" hint="Shown at the top of the About page" :error="form.errors.about_intro" />
                <TextArea v-model="form.about_vision" label="Vision Statement" rows="3" :error="form.errors.about_vision" />
                <TextArea v-model="form.about_mission" label="Mission Statement" rows="3" :error="form.errors.about_mission" />

                <label class="block text-xs font-semibold text-slate-600">Core Values</label>
                <div class="space-y-2">
                    <div v-for="(v, i) in form.core_values" :key="i" class="flex items-center gap-2">
                        <span class="w-6 text-center text-xs font-bold text-slate-400">{{ i + 1 }}</span>
                        <input v-model="form.core_values[i]" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" />
                        <button type="button" @click="removeValue(i)" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <button type="button" @click="addValue" class="inline-flex items-center gap-1.5 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-xs font-semibold text-slate-500 hover:border-brand-400 hover:text-brand-600">
                        + Add Value
                    </button>
                </div>

                <label class="block text-xs font-semibold text-slate-600">Company Info Table (About sidebar)</label>
                <div class="space-y-2">
                    <div v-for="(row, i) in form.company_info" :key="i" class="flex items-center gap-2">
                        <input v-model="row.label" placeholder="e.g. Established" class="w-44 shrink-0 rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:bg-white focus:ring-1 focus:ring-brand-500" />
                        <input v-model="row.value" placeholder="e.g. 2012" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" />
                        <button type="button" @click="removeInfo(i)" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <button type="button" @click="addInfo" class="inline-flex items-center gap-1.5 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-xs font-semibold text-slate-500 hover:border-brand-400 hover:text-brand-600">
                        + Add Row
                    </button>
                </div>
            </section>

            <!-- Stats -->
            <section v-show="activeTab === 'Homepage Stats'" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="mb-4 text-xs text-slate-400">Shown in the homepage stats band. Use short formats like “14+”, “250+”.</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <TextInput v-model="form.stat_years_experience" label="Years of Experience" :error="form.errors.stat_years_experience" placeholder="e.g. 14+" />
                    <TextInput v-model="form.stat_projects_completed" label="Projects Completed" :error="form.errors.stat_projects_completed" placeholder="e.g. 250+" />
                    <TextInput v-model="form.stat_experts" label="Experts & Engineers" :error="form.errors.stat_experts" placeholder="e.g. 120+" />
                    <TextInput v-model="form.stat_happy_clients" label="Happy Clients" :error="form.errors.stat_happy_clients" placeholder="e.g. 90+" />
                </div>
            </section>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : 'Save Settings' }}
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

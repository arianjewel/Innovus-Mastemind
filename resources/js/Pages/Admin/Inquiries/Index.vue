<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    inquiries: Object,
    filter: String,
    unreadCount: Number,
});

const expanded = ref(null);

const setFilter = (f) => {
    router.get(route('admin.inquiries.index'), f === 'all' ? {} : { filter: f }, {
        preserveState: true,
        only: ['inquiries', 'filter', 'unreadCount'],
    });
};

const toggleExpand = (inq) => {
    if (expanded.value === inq.id) {
        expanded.value = null;
        return;
    }
    expanded.value = inq.id;
    if (!inq.is_read) {
        markRead(inq);
    }
};

const markRead = (inq) => {
    router.patch(route('admin.inquiries.read', inq.id), {}, {
        preserveScroll: true,
        only: ['inquiries', 'unreadCount'],
    });
};

const destroy = (id) => {
    if (confirm('Delete this inquiry?')) {
        router.delete(route('admin.inquiries.destroy', id), { preserveScroll: true, only: ['inquiries', 'unreadCount'] });
    }
};

const fmtAmount = (n) => new Intl.NumberFormat('en-IN').format(Number(n));
</script>

<template>
    <Head title="Product Inquiries" />

    <AdminLayout>
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Product Inquiries</h1>
                <p class="text-sm text-slate-500">{{ unreadCount }} unread of {{ inquiries.total }}.</p>
            </div>
            <div class="flex gap-1 rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                <button @click="setFilter('all')" :class="filter === 'all' ? 'bg-brand-600 text-white' : 'text-slate-500 hover:bg-slate-100'" class="rounded-lg px-4 py-2 text-xs font-semibold transition">All</button>
                <button @click="setFilter('unread')" :class="filter === 'unread' ? 'bg-brand-600 text-white' : 'text-slate-500 hover:bg-slate-100'" class="rounded-lg px-4 py-2 text-xs font-semibold transition">Unread</button>
            </div>
        </div>

        <div v-if="inquiries.data.length" class="space-y-3">
            <article
                v-for="inq in inquiries.data"
                :key="inq.id"
                class="cursor-pointer rounded-2xl border bg-white shadow-sm transition hover:shadow-md"
                :class="[inq.is_read ? 'border-slate-200' : 'border-amber-300 ring-1 ring-amber-200']"
                @click="toggleExpand(inq)"
            >
                <div class="flex items-start gap-3 p-5">
                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full" :class="inq.is_read ? 'bg-transparent' : 'bg-amber-500'"></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3">
                            <h2 class="text-sm font-bold text-navy-900">
                                {{ inq.name }}
                                <span class="font-normal text-slate-400">→</span>
                                <span class="text-brand-700">{{ inq.product?.title ?? '—' }}</span>
                            </h2>
                            <time class="text-[11px] text-slate-400">{{ new Date(inq.created_at).toLocaleString() }}</time>
                        </div>
                        <p class="mt-0.5 text-xs text-slate-500">Qty: {{ inq.quantity ?? '—' }} · {{ inq.phone || inq.email || 'no contact info' }}</p>

                        <div v-if="expanded === inq.id" class="mt-3 space-y-2 border-t border-dashed border-slate-200 pt-3" @click.stop>
                            <dl class="grid gap-x-6 gap-y-2 text-sm sm:grid-cols-2">
                                <div><dt class="text-[11px] uppercase tracking-wide text-slate-400">Contact person</dt><dd class="font-medium text-slate-800">{{ inq.name }}</dd></div>
                                <div v-if="inq.company"><dt class="text-[11px] uppercase tracking-wide text-slate-400">Company</dt><dd class="text-slate-800">{{ inq.company }}</dd></div>
                                <div><dt class="text-[11px] uppercase tracking-wide text-slate-400">Phone</dt><dd class="text-slate-800">{{ inq.phone || '—' }}</dd></div>
                                <div><dt class="text-[11px] uppercase tracking-wide text-slate-400">Email</dt><dd class="text-slate-800">{{ inq.email || '—' }}</dd></div>
                                <div><dt class="text-[11px] uppercase tracking-wide text-slate-400">Quantity</dt><dd class="text-slate-800">{{ inq.quantity ?? '—' }}</dd></div>
                            </dl>
                            <p v-if="inq.message" class="whitespace-pre-wrap rounded-lg bg-slate-50 p-3 text-sm leading-relaxed text-slate-700">{{ inq.message }}</p>
                            <div class="flex flex-wrap gap-4 pt-1">
                                <a v-if="inq.phone" :href="`tel:${inq.phone}`" class="text-xs font-semibold text-brand-600 hover:text-brand-800">Call →</a>
                                <a v-if="inq.email" :href="`mailto:${inq.email}`" class="text-xs font-semibold text-brand-600 hover:text-brand-800">Reply by email →</a>
                                <button @click="destroy(inq.id)" class="ml-auto text-xs font-semibold text-red-500 hover:text-red-700">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <p v-else class="rounded-2xl border border-dashed border-slate-300 py-16 text-center text-sm text-slate-400">No inquiries here.</p>

        <Pagination v-if="inquiries.last_page > 1" :links="inquiries.links" :only="['inquiries']" class="mt-6" />
    </AdminLayout>
</template>

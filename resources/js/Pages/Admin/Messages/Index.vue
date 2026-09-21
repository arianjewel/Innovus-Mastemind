<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    messages: Object,
    filter: String,
    unreadCount: Number,
});

const expanded = ref(null);

const setFilter = (f) => {
    router.get(route('admin.messages.index'), f === 'all' ? {} : { filter: f }, {
        preserveState: true,
        only: ['messages', 'filter', 'unreadCount'],
    });
};

const toggleExpand = (msg) => {
    if (expanded.value === msg.id) {
        expanded.value = null;
        return;
    }
    expanded.value = msg.id;
    if (!msg.is_read) {
        markRead(msg);
    }
};

const markRead = (msg) => {
    router.patch(route('admin.messages.read', msg.id), {}, {
        preserveScroll: true,
        only: ['messages', 'unreadCount'],
    });
};

const destroy = (id) => {
    if (confirm('Delete this message?')) {
        router.delete(route('admin.messages.destroy', id), { preserveScroll: true, only: ['messages', 'unreadCount'] });
    }
};
</script>

<template>
    <Head title="Messages" />

    <AdminLayout>
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy-900">Contact Messages</h1>
                <p class="text-sm text-slate-500">{{ unreadCount }} unread of {{ messages.total }}.</p>
            </div>
            <div class="flex gap-1 rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                <button @click="setFilter('all')" :class="filter === 'all' ? 'bg-brand-600 text-white' : 'text-slate-500 hover:bg-slate-100'" class="rounded-lg px-4 py-2 text-xs font-semibold transition">All</button>
                <button @click="setFilter('unread')" :class="filter === 'unread' ? 'bg-brand-600 text-white' : 'text-slate-500 hover:bg-slate-100'" class="rounded-lg px-4 py-2 text-xs font-semibold transition">Unread</button>
            </div>
        </div>

        <div v-if="messages.data.length" class="space-y-3">
            <article
                v-for="msg in messages.data"
                :key="msg.id"
                class="cursor-pointer rounded-2xl border bg-white shadow-sm transition hover:shadow-md"
                :class="[msg.is_read ? 'border-slate-200' : 'border-brand-300 ring-1 ring-brand-200']"
                @click="toggleExpand(msg)"
            >
                <div class="flex items-start gap-3 p-5">
                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full" :class="msg.is_read ? 'bg-transparent' : 'bg-brand-500'"></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-3">
                            <h2 class="text-sm font-bold text-navy-900">{{ msg.name }}</h2>
                            <time class="text-[11px] text-slate-400">{{ new Date(msg.created_at).toLocaleString() }}</time>
                        </div>
                        <p class="mt-0.5 text-xs text-slate-400">{{ msg.email || 'no email' }}<template v-if="msg.phone"> · {{ msg.phone }}</template></p>
                        <p v-if="expanded !== msg.id && msg.subject" class="mt-1.5 truncate text-sm font-medium text-slate-600">{{ msg.subject }}</p>
                        <p v-if="expanded !== msg.id && !msg.subject" class="mt-1.5 truncate text-sm text-slate-500">{{ msg.message }}</p>

                        <div v-if="expanded === msg.id" class="mt-3 space-y-2 border-t border-dashed border-slate-200 pt-3" @click.stop>
                            <p v-if="msg.subject" class="text-sm"><strong>Subject:</strong> {{ msg.subject }}</p>
                            <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ msg.message }}</p>
                            <div class="flex gap-4 pt-2">
                                <a v-if="msg.email" :href="`mailto:${msg.email}`" class="text-xs font-semibold text-brand-600 hover:text-brand-800">Reply by email →</a>
                                <button v-if="!msg.is_read" @click="markRead(msg)" class="text-xs font-semibold text-slate-500 hover:text-slate-700">Mark read</button>
                                <button @click="destroy(msg.id)" class="text-xs font-semibold text-red-500 hover:text-red-700">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <p v-else class="rounded-2xl border border-dashed border-slate-300 py-16 text-center text-sm text-slate-400">No messages here.</p>

        <Pagination v-if="messages.last_page > 1" :links="messages.links" :only="['messages']" class="mt-6" />
    </AdminLayout>
</template>

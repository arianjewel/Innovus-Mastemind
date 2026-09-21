<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    counts: Object,
    unreadMessages: Number,
    unreadInquiries: Number,
    latestMessages: Array,
    latestInquiries: Array,
});

const statCards = [
    { label: 'Products', value: props.counts.products, href: '/admin/products', color: 'bg-brand-600', icon: 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m16.5 0h-16.5m16.5 0c0-1.242-3.358-2.25-7.5-2.25s-7.5 1.008-7.5 2.25' },
    { label: 'Projects', value: props.counts.projects, href: '/admin/projects', color: 'bg-navy-700', icon: 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586' },
    { label: 'Services', value: props.counts.services, href: '/admin/services', color: 'bg-emerald-500', icon: 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26' },
    { label: 'Team Members', value: props.counts.teamMembers, href: '/admin/team-members', color: 'bg-sky-500', icon: 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0z' },
    { label: 'Clients', value: props.counts.clients, href: '/admin/clients', color: 'bg-violet-500', icon: 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21' },
    { label: 'Unread Messages', value: props.unreadMessages, href: '/admin/messages', color: 'bg-amber-500', icon: 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75' },
];

const ago = (date) => {
    const d = new Date(date);
    const diff = Math.floor((Date.now() - d.getTime()) / 1000);
    if (diff < 60) return 'just now';
    if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
    if (diff < 604800) return `${Math.floor(diff / 86400)}d ago`;
    return d.toLocaleDateString();
};
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="mb-6">
            <h1 class="text-xl font-bold text-navy-900">Dashboard</h1>
            <p class="text-sm text-slate-500">Overview of your website content and activity.</p>
        </div>

        <!-- Stat cards -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <Link
                v-for="card in statCards"
                :key="card.label"
                :href="card.href"
                class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
            >
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl text-white" :class="card.color">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" :d="card.icon"/></svg>
                </span>
                <div>
                    <p class="text-2xl font-bold tabular-nums text-navy-900">{{ card.value }}</p>
                    <p class="text-xs font-medium text-slate-500">{{ card.label }}</p>
                </div>
            </Link>
        </div>

        <!-- Recent activity -->
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-sm font-bold text-navy-900">Latest Messages</h2>
                    <Link href="/admin/messages" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all →</Link>
                </header>
                <ul v-if="latestMessages.length" class="divide-y divide-slate-100">
                    <li v-for="msg in latestMessages" :key="msg.id">
                        <Link :href="route('admin.messages.index')" class="flex items-start gap-3 px-5 py-3.5 transition hover:bg-slate-50">
                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full" :class="msg.is_read ? 'bg-transparent' : 'bg-brand-500'"></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ msg.name }} — {{ msg.subject || '(no subject)' }}</p>
                            </div>
                            <time class="shrink-0 text-[11px] text-slate-400">{{ ago(msg.created_at) }}</time>
                        </Link>
                    </li>
                </ul>
                <p v-else class="px-5 py-10 text-center text-sm text-slate-400">No messages yet.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-sm font-bold text-navy-900">Latest Product Inquiries</h2>
                    <Link href="/admin/inquiries" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all →</Link>
                </header>
                <ul v-if="latestInquiries.length" class="divide-y divide-slate-100">
                    <li v-for="inq in latestInquiries" :key="inq.id">
                        <Link :href="route('admin.inquiries.index')" class="flex items-start gap-3 px-5 py-3.5 transition hover:bg-slate-50">
                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full" :class="inq.is_read ? 'bg-transparent' : 'bg-amber-500'"></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ inq.name }} → {{ inq.product?.title ?? '—' }}</p>
                                <p class="mt-0.5 truncate text-xs text-slate-500">Qty {{ inq.quantity ?? '-' }} · {{ inq.phone }}</p>
                            </div>
                            <time class="shrink-0 text-[11px] text-slate-400">{{ ago(inq.created_at) }}</time>
                        </Link>
                    </li>
                </ul>
                <p v-else class="px-5 py-10 text-center text-sm text-slate-400">No inquiries yet.</p>
            </section>
        </div>
    </AdminLayout>
</template>

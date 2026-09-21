<script setup>
import { ref, computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import FlashToast from '@/Components/FlashToast.vue';

const page = usePage();
const mobileOpen = ref(false);

const site = computed(() => page.props.site ?? {});
const auth = computed(() => page.props.auth?.user);

const nav = [
    { label: 'Home', href: '/' },
    { label: 'About Us', href: '/about' },
    { label: 'Services', href: '/services' },
    { label: 'Products', href: '/products' },
    { label: 'Projects', href: '/projects' },
    { label: 'E-Brochure', href: '/ebrochure' },
    { label: 'Contact', href: '/contact' },
];

const isActive = (href) => {
    if (href === '/') return page.url === '/';
    return page.url.startsWith(href);
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-white">
        <Head>
            <meta property="og:site_name" :content="site.site_name" />
        </Head>

        <!-- Top info bar -->
        <div class="bg-navy-900 text-slate-300 text-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1.5 flex items-center justify-between gap-4">
                <p class="truncate">{{ site.tagline }}</p>
                <div class="hidden md:flex items-center gap-4">
                    <a v-if="site.phone_primary" :href="`tel:${site.phone_primary}`" class="hover:text-white">📞 {{ site.phone_primary }}</a>
                    <a v-if="site.email_primary" :href="`mailto:${site.email_primary}`" class="hover:text-white truncate">✉ {{ site.email_primary }}</a>
                </div>
            </div>
        </div>

        <!-- Main nav -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <Link href="/" class="flex items-center gap-2.5 shrink-0">
                        <img
                            v-if="site.logo_path"
                            :src="`/storage/${site.logo_path}`"
                            alt="logo"
                            class="h-10 w-auto rounded"
                        />
                        <span v-else class="h-10 w-10 rounded-lg bg-brand-700 text-white grid place-items-center font-bold">IM</span>
                        <span class="leading-tight">
                            <span class="block font-bold text-navy-900">{{ site.site_name || 'Innovus Mastermind' }}</span>
                            <span class="block text-[11px] tracking-wide text-brand-700 uppercase">{{ site.tagline }}</span>
                        </span>
                    </Link>

                    <nav class="hidden lg:flex items-center gap-1">
                        <Link
                            v-for="item in nav"
                            :key="item.href"
                            :href="item.href"
                            class="px-3 py-2 rounded-md text-sm font-medium transition"
                            :class="isActive(item.href)
                                ? 'text-brand-700 bg-brand-50'
                                : 'text-slate-600 hover:text-navy-900 hover:bg-slate-100'"
                        >
                            {{ item.label }}
                        </Link>
                        <Link
                            v-if="auth?.is_admin"
                            :href="'/admin'"
                            class="ml-2 px-3 py-2 rounded-md bg-navy-900 text-white text-sm font-medium hover:bg-navy-800"
                        >
                            Admin
                        </Link>
                    </nav>

                    <button
                        class="lg:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Toggle menu"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <transition
                enter-active-class="transition duration-150 ease-out" enter-from-class="-translate-y-2 opacity-0"
                leave-active-class="transition duration-100 ease-in" leave-to-class="-translate-y-2 opacity-0"
            >
                <nav v-if="mobileOpen" class="lg:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1 shadow-lg">
                    <Link
                        v-for="item in nav"
                        :key="item.href"
                        :href="item.href"
                        class="block px-3 py-2.5 rounded-md text-sm font-medium"
                        :class="isActive(item.href) ? 'text-brand-700 bg-brand-50' : 'text-slate-700 hover:bg-slate-100'"
                        @click="mobileOpen = false"
                    >
                        {{ item.label }}
                    </Link>
                    <Link v-if="auth?.is_admin" :href="'/admin'" class="block px-3 py-2.5 rounded-md text-sm font-medium bg-navy-900 text-white" @click="mobileOpen = false">
                        Admin Panel
                    </Link>
                </nav>
            </transition>
        </header>

        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-navy-950 text-slate-300 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img v-if="site.logo_path" :src="`/storage/${site.logo_path}`" class="h-10 w-auto rounded bg-white p-0.5" alt="logo" />
                        <div>
                            <p class="font-bold text-white">{{ site.site_name }}</p>
                            <p class="text-xs text-brand-300 uppercase tracking-wide">{{ site.tagline }}</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">{{ site.footer_text }}</p>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li v-for="item in nav" :key="item.href">
                            <Link :href="item.href" class="hover:text-brand-300">{{ item.label }}</Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li v-if="site.address" class="flex gap-2"><span>📍</span><span>{{ site.address }}</span></li>
                        <li v-if="site.phone_primary" class="flex gap-2"><span>📞</span><a :href="`tel:${site.phone_primary}`" class="hover:text-brand-300">{{ site.phone_primary }}</a></li>
                        <li v-if="site.email_primary" class="flex gap-2"><span>✉</span><a :href="`mailto:${site.email_primary}`" class="hover:text-brand-300 break-all">{{ site.email_primary }}</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Follow Us</h4>
                    <div class="flex gap-3">
                        <a v-if="site.facebook_url" :href="site.facebook_url" target="_blank" rel="noopener" aria-label="Facebook" class="h-10 w-10 grid place-items-center rounded-full bg-white/10 hover:bg-brand-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5 21v-8h2.7l.4-3.2h-3.1V7.7c0-.9.3-1.6 1.6-1.6h1.7V3.2c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.4H7.4V13h2.7v8h3.4z"/></svg>
                        </a>
                        <a v-if="site.linkedin_url" :href="site.linkedin_url" target="_blank" rel="noopener" aria-label="LinkedIn" class="h-10 w-10 grid place-items-center rounded-full bg-white/10 hover:bg-brand-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.9 8.9H3.6V21h3.3V8.9zM5.2 3.5a2 2 0 100 4 2 2 0 000-4zM20.4 13.4c0-3.1-1.7-4.6-3.9-4.6-1.8 0-2.6 1-3 1.7V8.9h-3.3V21h3.3v-6.5c0-1.5.7-2.4 2-2.4s1.9.9 1.9 2.4V21h3.3v-7.6z"/></svg>
                        </a>
                        <a v-if="site.youtube_url" :href="site.youtube_url" target="_blank" rel="noopener" aria-label="YouTube" class="h-10 w-10 grid place-items-center rounded-full bg-white/10 hover:bg-brand-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 7.2s-.2-1.6-.9-2.3c-.9-.9-1.8-.9-2.3-1C16.6 3.6 12 3.6 12 3.6h0s-4.6 0-7.8.3c-.4.1-1.4.1-2.3 1-.7.7-.9 2.3-.9 2.3S.8 9.1.8 11v1.8c0 1.9.2 3.8.2 3.8s.2 1.6.9 2.3c.9.9 2 .9 2.5 1 1.8.2 7.6.3 7.6.3s4.6 0 7.8-.3c.4-.1 1.4-.1 2.3-1 .7-.7.9-2.3.9-2.3s.2-1.9.2-3.8V11c0-1.9-.2-3.8-.2-3.8zM9.8 15V8.4l6.1 3.3L9.8 15z"/></svg>
                        </a>
                        <a v-if="site.whatsapp_number" :href="`https://wa.me/${String(site.whatsapp_number).replace(/[^0-9]/g, '')}`" target="_blank" rel="noopener" aria-label="WhatsApp" class="h-10 w-10 grid place-items-center rounded-full bg-white/10 hover:bg-green-500 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.1-.2.3-.7 1-.9 1.2-.2.2-.3.2-.6.1-.3-.2-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.5-.6c.1-.2.2-.3.3-.5v-.5C9.9 8.8 9.3 7.3 9 6.7c-.1-.4-.3-.4-.5-.4h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.1-.3-.2-.7-.4z M12 2A10 10 0 002 12c0 1.8.5 3.4 1.3 4.9L2 22l5.2-1.3A10 10 0 1012 2zm0 18.2c-1.6 0-3-.4-4.3-1.2l-.3-.2-3.1.8.8-3-.2-.3A8.2 8.2 0 1120.2 12c0 4.5-3.7 8.2-8.2 8.2z"/></svg>
                        </a>
                    </div>
                    <p class="mt-6 text-xs text-slate-500">&copy; {{ new Date().getFullYear() }} {{ site.site_name }}. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <FlashToast />
    </div>
</template>

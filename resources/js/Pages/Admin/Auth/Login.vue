<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Login" />

    <div class="grid min-h-screen bg-navy-950 lg:grid-cols-2">
        <!-- Brand side -->
        <div class="relative hidden overflow-hidden lg:block">
            <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 25% 20%, #0891b2 0%, transparent 50%), radial-gradient(circle at 80% 85%, #155e75 0%, transparent 45%)"></div>
            <div class="relative flex h-full flex-col justify-between p-12">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-600 font-bold text-white">IM</span>
                    <div>
                        <p class="font-bold text-white">Innovus Mastermind</p>
                        <p class="text-xs text-brand-400">Building Tomorrow, Today</p>
                    </div>
                </div>
                <div>
                    <h1 class="max-w-md text-3xl font-bold leading-snug text-white">Manage your website content from one place.</h1>
                    <ul class="mt-6 space-y-2 text-sm text-slate-400">
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> Products & catalog management</li>
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> Project portfolio with documents</li>
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> Customer messages & inquiries</li>
                    </ul>
                </div>
                <p class="text-xs text-slate-600">© {{ new Date().getFullYear() }} Innovus Mastermind Ltd.</p>
            </div>
        </div>

        <!-- Form side -->
        <div class="flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-sm">
                <div class="mb-8 lg:hidden">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-600 font-bold text-white">IM</span>
                </div>

                <h2 class="text-2xl font-bold text-white">Admin Login</h2>
                <p class="mt-1.5 mb-7 text-sm text-slate-400">Sign in to access the control panel.</p>

                <div v-if="status" class="mb-4 rounded-lg border border-brand-700/50 bg-brand-900/40 px-4 py-3 text-sm text-brand-300">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="email" class="mb-1 block text-xs font-semibold text-slate-400">Email address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin@innovus.com.bd"
                            class="w-full rounded-lg border border-slate-700 bg-slate-800/60 px-3.5 py-2.5 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-xs font-medium text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-xs font-semibold text-slate-400">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••••••"
                                class="w-full rounded-lg border border-slate-700 bg-slate-800/60 px-3.5 py-2.5 pr-16 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[11px] font-semibold uppercase text-brand-400 hover:text-brand-300"
                            >
                                {{ showPassword ? 'Hide' : 'Show' }}
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-1 text-xs font-medium text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-lg bg-brand-600 py-2.5 font-semibold text-white shadow-lg shadow-brand-900/40 transition hover:bg-brand-500 disabled:opacity-60"
                    >
                        {{ form.processing ? 'Signing in…' : 'Sign In' }}
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-slate-500">
                    <a href="/" class="hover:text-brand-400">← Back to website</a>
                </p>
            </div>
        </div>
    </div>
</template>

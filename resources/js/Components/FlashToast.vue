<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

// simple self-dismissing toast driven by shared flash props
watch(
    () => [page.props.flash?.success, page.props.flash?.error],
    () => {
        if (page.props.flash?.success || page.props.flash?.error) {
            setTimeout(() => {
                if (page.props.flash) {
                    page.props.flash.success = null;
                    page.props.flash.error = null;
                }
            }, 5000);
        }
    },
    { immediate: true }
);
</script>

<template>
    <div class="fixed top-5 right-5 z-[100] space-y-3 w-80 max-w-[90vw]">
        <transition
            enter-active-class="transition duration-200 ease-out" enter-from-class="translate-x-6 opacity-0"
            leave-active-class="transition duration-150 ease-in" leave-to-class="translate-x-6 opacity-0"
        >
            <div
                v-if="page.props.flash?.success"
                class="flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 shadow-lg"
                role="status"
            >
                <svg class="h-5 w-5 shrink-0 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.5l2.5 2.5L16 10"/>
                    <circle cx="12" cy="12" r="9"/>
                </svg>
                <p class="text-sm text-green-800">{{ page.props.flash.success }}</p>
            </div>
        </transition>
        <transition
            enter-active-class="transition duration-200 ease-out" enter-from-class="translate-x-6 opacity-0"
            leave-active-class="transition duration-150 ease-in" leave-to-class="translate-x-6 opacity-0"
        >
            <div
                v-if="page.props.flash?.error"
                class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 shadow-lg"
                role="alert"
            >
                <svg class="h-5 w-5 shrink-0 text-red-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/>
                </svg>
                <p class="text-sm text-red-800">{{ page.props.flash.error }}</p>
            </div>
        </transition>
    </div>
</template>

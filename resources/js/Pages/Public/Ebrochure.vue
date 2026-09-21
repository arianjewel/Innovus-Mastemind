<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { PageFlip } from 'page-flip';
import * as pdfjsLib from 'pdfjs-dist';
import workerUrl from 'pdfjs-dist/build/pdf.worker.min.mjs?url';

pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;

const props = defineProps({
    brochure: Object,
});

const bookEl = ref(null);
const stageEl = ref(null);
const wrapper = ref(null);

const state = ref('idle'); // idle | loading | ready | error
const progress = ref(0);
const errorMessage = ref('');
const currentPage = ref(1);
const totalPages = ref(0);
const zoom = ref(1);
const isFullscreen = ref(false);

let pageFlip = null;
let objectUrls = [];

/* ---------------- build flipbook ---------------- */
async function buildBook() {
    if (!props.brochure) return;
    state.value = 'loading';
    progress.value = 0;

    try {
        const doc = await pdfjsLib.getDocument({ url: props.brochure.url }).promise;
        totalPages.value = doc.numPages;
        const urls = [];

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // A4 portrait ratio; render at good resolution
        const targetWidth = 900;

        for (let n = 1; n <= doc.numPages; n++) {
            const page = await doc.getPage(n);
            const viewport = page.getViewport({ scale: 1 });
            const scale = targetWidth / viewport.width;
            const scaled = page.getViewport({ scale });

            canvas.width = Math.floor(scaled.width);
            canvas.height = Math.floor(scaled.height);
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            await page.render({ canvasContext: ctx, viewport: scaled }).promise;

            const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.85));
            const url = URL.createObjectURL(blob);
            objectUrls.push(url);
            urls.push(url);

            progress.value = Math.round((n / doc.numPages) * 100);
        }

        await nextTick();

        if (!bookEl.value) throw new Error('Container missing');

        pageFlip = new PageFlip(bookEl.value, {
            width: 472,
            height: 650,
            size: 'stretch',
            minWidth: 280,
            maxWidth: 1000,
            minHeight: 380,
            maxHeight: 1350,
            showCover: true,
            mobileScrollSupport: false,
            maxShadowOpacity: 0.5,
            flippingTime: 700,
            usePortrait: true,
            startZIndex: 5,
            autoSize: true,
        });

        pageFlip.loadFromImages(urls);
        pageFlip.on('flip', (e) => {
            currentPage.value = e.data + 1 > doc.numPages ? doc.numPages : e.data + 1;
        });
        pageFlip.on('changeState', () => {});

        state.value = 'ready';
    } catch (err) {
        console.error('E-brochure load failed:', err);
        errorMessage.value = err?.message || 'Could not load the brochure.';
        state.value = 'error';
    }
}

onMounted(() => {
    document.addEventListener('fullscreenchange', onFsChange);
    buildBook();
});

onBeforeUnmount(() => {
    document.removeEventListener('fullscreenchange', onFsChange);
    objectUrls.forEach((u) => URL.revokeObjectURL(u));
});

function onFsChange() {
    isFullscreen.value = Boolean(document.fullscreenElement);
}

/* ---------------- controls ---------------- */
const prev = () => pageFlip?.flipPrev();
const next = () => pageFlip?.flipNext();
const jumpTo = (page) => {
    const target = Math.min(Math.max(2, Number(page)), totalPages.value - 1);
    pageFlip?.flip(target);
};

const zoomIn = () => { zoom.value = Math.min(zoom.value + 0.25, 2.25); applyZoom(); };
const zoomOut = () => { zoom.value = Math.max(zoom.value - 0.25, 1); applyZoom(); };
const resetZoom = () => { zoom.value = 1; applyZoom(); };

function applyZoom() {
    if (wrapper.value) {
        wrapper.value.style.transform = `scale(${zoom.value})`;
    }
}

const toggleFullscreen = async () => {
    try {
        if (!document.fullscreenElement) {
            await stageEl.value.requestFullscreen();
        } else {
            await document.exitFullscreen();
        }
    } catch {
        /* ignore unsupported */
    }
};

const fmtSize = (bytes) => {
    let b = bytes || 0;
    const units = ['B', 'KB', 'MB'];
    let i = 0;
    while (b >= 1024 && i < units.length - 1) { b /= 1024; i++; }
    return `${b.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
};
</script>

<template>
    <PublicLayout>
        <Head title="E-Brochure" />

        <!-- header band -->
        <section class="bg-navy-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <p class="text-brand-400 font-semibold tracking-widest uppercase text-sm">Company Profile</p>
                <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white">{{ brochure?.title || 'E-Brochure' }}</h1>
                    <a
                        v-if="brochure"
                        href="/ebrochure/download"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-600 hover:bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Download PDF
                        <span v-if="brochure.sizeBytes" class="font-normal text-brand-200">({{ fmtSize(brochure.sizeBytes) }})</span>
                    </a>
                </div>
                <p v-if="brochure?.description" class="mt-2 text-slate-300 max-w-2xl">{{ brochure.description }}</p>
            </div>
        </section>

        <!-- viewer -->
        <section class="bg-slate-100 py-10 min-h-[60vh]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- toolbar -->
                <div
                    v-if="state === 'ready'"
                    class="mx-auto mb-4 flex max-w-fit items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 shadow-md"
                >
                    <button @click="prev" :disabled="currentPage <= 1" class="grid h-9 w-9 place-items-center rounded-full text-slate-600 hover:bg-slate-100 disabled:opacity-40 transition" aria-label="Previous page">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </button>

                    <span class="select-none px-2 text-sm font-medium tabular-nums text-slate-600">
                        {{ currentPage }} / {{ totalPages }}
                    </span>

                    <button @click="next" :disabled="currentPage >= totalPages" class="grid h-9 w-9 place-items-center rounded-full text-slate-600 hover:bg-slate-100 disabled:opacity-40 transition" aria-label="Next page">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </button>

                    <span class="mx-1 h-6 w-px bg-slate-200"></span>

                    <button @click="zoomOut" class="grid h-9 w-9 place-items-center rounded-full text-slate-600 hover:bg-slate-100 transition" aria-label="Zoom out">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 12H5.25"/></svg>
                    </button>
                    <button @click="resetZoom" class="min-w-[52px] rounded-full px-2 py-1.5 text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">{{ Math.round(zoom * 100) }}%</button>
                    <button @click="zoomIn" class="grid h-9 w-9 place-items-center rounded-full text-slate-600 hover:bg-slate-100 transition" aria-label="Zoom in">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </button>

                    <span class="mx-1 h-6 w-px bg-slate-200"></span>

                    <button @click="toggleFullscreen" class="grid h-9 w-9 place-items-center rounded-full text-slate-600 hover:bg-slate-100 transition" aria-label="Fullscreen">
                        <svg v-if="!isFullscreen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9M3.75 20.25h4.5m-4.5 0v-4.5m0 4.5L9 15M20.25 20.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                        <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M15 9V4.5M15 9h4.5M15 9l5.25-5.25M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/></svg>
                    </button>
                </div>

                <!-- book: always mounted so PageFlip can measure dimensions -->
                <div
                    ref="stageEl"
                    class="relative overflow-auto rounded-2xl bg-gradient-to-br from-navy-900 to-navy-950 p-4 sm:p-10 shadow-inner"
                >
                    <!-- loading overlay -->
                    <div v-if="state === 'loading'" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-navy-950/90 backdrop-blur-sm">
                        <svg class="h-14 w-14 animate-spin text-brand-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <p class="mt-5 font-medium text-slate-200">Preparing brochure pages… {{ progress }}%</p>
                        <div class="mt-4 h-2 w-64 overflow-hidden rounded-full bg-slate-700">
                            <div class="h-full rounded-full bg-brand-500 transition-all duration-300" :style="{ width: progress + '%' }"></div>
                        </div>
                    </div>

                    <!-- error overlay -->
                    <div v-if="state === 'error'" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-navy-950/90 backdrop-blur-sm py-24 text-center">
                        <p class="text-red-500 font-semibold">Something went wrong</p>
                        <p class="mt-2 text-sm text-slate-300">{{ errorMessage }}</p>
                    </div>

                    <!-- empty overlay -->
                    <div v-if="!brochure" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-navy-950/90 py-24 text-center">
                        <h3 class="text-lg font-semibold text-slate-200">No brochure published yet</h3>
                        <p class="mt-1 text-sm text-slate-400">Please check back later.</p>
                    </div>

                    <div class="flex justify-center origin-top transition-transform duration-200" ref="wrapper">
                        <div ref="bookEl" class="fb-book"></div>
                    </div>
                    <p v-if="state === 'ready'" class="mt-6 select-none text-center text-xs text-slate-400">Drag page corners or use the arrows to turn pages · double-click a corner for fast flip</p>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.fb-book :deep(.stf__parent) {
    margin: 0 auto;
}
.fb-book :deep(.stf__item) {
    box-shadow: 0 12px 30px rgba(2, 12, 27, 0.45);
}
</style>

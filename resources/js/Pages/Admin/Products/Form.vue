<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/Admin/TextInput.vue';
import TextArea from '@/Components/Admin/TextArea.vue';
import SelectInput from '@/Components/Admin/SelectInput.vue';
import Toggle from '@/Components/Admin/Toggle.vue';

const props = defineProps({
    product: { type: Object, default: null },
    categories: Array,
    brands: Array,
});

const isEdit = Boolean(props.product);

const specRows = ref(
    props.product?.specifications?.length
        ? props.product.specifications.map((r) => ({ label: r.label ?? '', value: r.value ?? '' }))
        : [{ label: '', value: '' }],
);

const addSpec = () => {
    if (!String(specRows.value.at(-1)?.label ?? '').trim()) return;
    specRows.value.push({ label: '', value: '' });
};
const removeSpec = (i) => {
    if (i === 0 && specRows.value.length === 1) {
        specRows.value = [{ label: '', value: '' }];
        return;
    }
    specRows.value.splice(i, 1);
};

const form = useForm({
    title: props.product?.title ?? '',
    sku: props.product?.sku ?? '',
    category_id: props.product?.category_id ?? '',
    brand_id: props.product?.brand_id ?? '',
    price: props.product?.price ?? '',
    old_price: props.product?.old_price ?? '',
    currency: props.product?.currency ?? 'BDT',
    unit: props.product?.unit ?? 'unit',
    short_desc: props.product?.short_desc ?? '',
    details: props.product?.details ?? '',
    specifications: [],
    is_featured: props.product?.is_featured ?? false,
    is_active: props.product?.is_active ?? true,
    images: null,
});

const newImages = ref(null);
const galleryInput = ref(null);

const currencyOptions = [
    { value: 'BDT', label: 'BDT (৳)' },
    { value: 'USD', label: 'USD ($)' },
];

const onPickImages = (e) => {
    if (isEdit) {
        newImages.value = e.target.files;
    } else {
        form.images = e.target.files;
    }
};

const submit = () => {
    form.specifications = specRows.value.filter((r) => String(r.label).trim());

    const options = { preserveScroll: true };
    if (isEdit) {
        form.transform((data) => ({ ...data, images: undefined }))
            .put(route('admin.products.update', props.product.id), options);
    } else {
        form.post(route('admin.products.store'), options);
    }
};

/* ---- gallery management (edit mode only) ---- */
const uploadImages = () => {
    if (!newImages.value || !newImages.value.length) return;
    const payload = new FormData();
    payload.append('_method', 'PATCH');
    Array.from(newImages.value).forEach((f) => payload.append('images[]', f));
    router.post(route('admin.products.update_images', props.product.id), payload, {
        preserveScroll: true,
        onFinish: () => {
            newImages.value = null;
            if (galleryInput.value) galleryInput.value.value = '';
        },
    });
};

const destroyImage = (imgId) => {
    if (!confirm('Remove this image?')) return;
    router.delete(route('product-images.destroy', imgId), { preserveScroll: true });
};

const makeCover = (imgId) => {
    router.patch(route('product-images.cover', imgId), {}, { preserveScroll: true });
};
</script>

<template>
    <Head :title="isEdit ? `Edit ${product.title}` : 'New Product'" />

    <AdminLayout>
        <div class="mb-6">
            <Link :href="route('admin.products.index')" class="text-xs font-semibold text-slate-500 hover:text-brand-600">← Back to Products</Link>
            <h1 class="mt-1 text-xl font-bold text-navy-900">{{ isEdit ? product.title : 'New Product' }}</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="grid max-w-6xl items-start gap-6 xl:grid-cols-[1fr_360px]">
            <div class="space-y-6">
                <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <TextInput v-model="form.title" label="Product Title" required :error="form.errors.title" placeholder="e.g. Tower Crane QTZ80" />
                    <div class="grid gap-4 sm:grid-cols-2">
                        <TextInput v-model="form.sku" label="SKU / Model" :error="form.errors.sku" />
                        <SelectInput v-model="form.currency" label="Currency" :options="currencyOptions" />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <TextInput v-model="form.price" label="Price *" type="number" step="0.01" min="0" required :error="form.errors.price" placeholder="e.g. 12500000" />
                        <TextInput v-model="form.old_price" label="Old Price (optional)" type="number" step="0.01" min="0" :error="form.errors.old_price" />
                        <TextInput v-model="form.unit" label="Unit" :error="form.errors.unit" placeholder="e.g. piece / ton / set" />
                    </div>
                    <TextArea v-model="form.short_desc" label="Short Description" rows="2" hint="Shown on catalog cards" :error="form.errors.short_desc" />
                    <TextArea v-model="form.details" label="Full Details" rows="8" hint="Paragraphs separated by a blank line; shown on the product page" :error="form.errors.details" />
                </section>

                <!-- Specifications -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Technical Specifications</label>
                    <div class="space-y-2">
                        <div v-for="(row, i) in specRows" :key="i" class="flex items-center gap-2">
                            <span class="w-6 text-center text-xs font-bold text-slate-400">{{ i + 1 }}</span>
                            <input
                                v-model="row.label"
                                placeholder="e.g. Max Lifting Capacity"
                                class="w-56 shrink-0 rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:bg-white focus:ring-1 focus:ring-brand-500"
                            />
                            <input
                                v-model="row.value"
                                placeholder="e.g. 8 t"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                            />
                            <button
                                type="button"
                                @click="removeSpec(i)"
                                class="grid h-9 w-9 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                                aria-label="Remove"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="addSpec"
                        class="mt-3 inline-flex items-center gap-1.5 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-xs font-semibold text-slate-500 transition hover:border-brand-400 hover:text-brand-600"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Add Specification
                    </button>
                    <p v-if="form.errors.specifications" class="mt-2 text-xs font-medium text-red-600">{{ form.errors.specifications }}</p>
                </section>

                <!-- Image upload -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-navy-900">
                        {{ isEdit ? 'Add Images to Gallery' : 'Product Images *' }}
                    </h2>
                    <p class="mb-4 mt-1 text-xs text-slate-400">First image becomes the cover · JPG/PNG/WebP · recommended 1200×800.</p>
                    <input
                        ref="galleryInput"
                        type="file"
                        accept="image/*"
                        multiple
                        name="images"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-700 hover:file:bg-brand-100"
                        @change="onPickImages"
                    />
                    <p v-if="!isEdit && !newImages?.length" class="mt-2 text-xs text-slate-400">At least one image is required on create.</p>
                </section>

                <!-- Existing gallery (edit mode) -->
                <section v-if="isEdit" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-1 text-sm font-bold text-navy-900">Gallery</h2>
                    <p class="mb-4 text-xs text-slate-400">Hover an image to manage it.</p>
                    <div v-if="product.images?.length" class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <figure
                            v-for="(img, i) in product.images"
                            :key="img.id"
                            class="group relative overflow-hidden rounded-xl border border-slate-200"
                            :class="i === 0 ? 'ring-2 ring-brand-500' : ''"
                        >
                            <img :src="`/storage/${img.path}`" class="aspect-[4/3] w-full object-cover" />
                            <figcaption class="absolute inset-x-0 bottom-0 flex justify-center gap-1 bg-gradient-to-t from-black/70 to-transparent p-2 opacity-0 transition group-hover:opacity-100">
                                <button v-if="i !== 0" type="button" @click="makeCover(img.id)" class="rounded bg-white/90 px-2 py-1 text-[10px] font-bold text-slate-700 hover:bg-white">COVER</button>
                                <button type="button" @click="destroyImage(img.id)" class="rounded bg-red-500/90 px-2 py-1 text-[10px] font-bold text-white hover:bg-red-500">DELETE</button>
                            </figcaption>
                            <span v-if="i === 0" class="absolute left-2 top-2 rounded bg-brand-600 px-1.5 py-0.5 text-[9px] font-bold uppercase text-white">Cover</span>
                        </figure>
                    </div>
                    <p v-else class="text-sm text-slate-400">No images yet — upload above and save.</p>

                    <button
                        type="button"
                        :disabled="!newImages?.length"
                        @click="uploadImages"
                        class="mt-4 rounded-lg bg-navy-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-brand-600 disabled:opacity-50"
                    >
                        Upload {{ newImages?.length ? `${newImages.length} image(s)` : '' }}
                    </button>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <section class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-navy-900">Organization</h2>
                    <SelectInput
                        v-model="form.category_id"
                        label="Category"
                        :options="[{ value: '', label: '— none —' }, ...categories.map((c) => ({ value: c.id, label: c.name }))]"
                        :error="form.errors.category_id"
                    />
                    <SelectInput
                        v-model="form.brand_id"
                        label="Brand"
                        :options="[{ value: '', label: '— none —' }, ...brands.map((b) => ({ value: b.id, label: b.name }))]"
                        :error="form.errors.brand_id"
                    />
                </section>

                <section class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-navy-900">Visibility</h2>
                    <Toggle v-model="form.is_featured" label="Featured on homepage" />
                    <Toggle v-model="form.is_active" label="Active (visible publicly)" />
                </section>

                <button type="submit" :disabled="form.processing" class="w-full rounded-lg bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-500 disabled:opacity-60">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Update Product' : 'Create Product' }}
                </button>
                <Link :href="route('admin.products.index')" class="block text-center text-sm font-medium text-slate-500 hover:text-slate-700">Cancel</Link>
            </div>
        </form>
    </AdminLayout>
</template>

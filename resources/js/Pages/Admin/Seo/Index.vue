<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    seoSettings: Array,
});

const form = useForm({
    settings: JSON.parse(JSON.stringify(props.seoSettings)),
});

const submit = () => {
    form.put(route('admin.seo.update'), {
        preserveScroll: true,
    });
};

const formatPageName = (slug) => {
    const names = {
        home: 'Beranda',
        services: 'Layanan & Fitur',
        pricing: 'Harga & Paket',
        contact: 'Hubungi Kami',
        blog: 'Blog & Artikel',
    };
    return names[slug] || slug.charAt(0).toUpperCase() + slug.slice(1);
};

const uploadOgImage = async (event, index) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await axios.post(route('admin.upload'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        form.settings[index].og_image_url = response.data.url;
    } catch (error) {
        alert('Gagal mengupload gambar.');
    } finally {
        event.target.value = '';
    }
};

const titleCharCount = (title) => {
    return (title || '').length;
};

const descCharCount = (desc) => {
    return (desc || '').length;
};
</script>

<template>
    <Head title="Pengaturan SEO" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Pengaturan SEO Halaman
                </h2>
                <button @click="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition disabled:opacity-50">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan SEO' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8 space-y-6">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                    {{ $page.props.flash.success }}
                </div>

                <p class="text-sm text-gray-500">Atur meta title, meta description, dan OG image untuk setiap halaman publik. Pengaturan ini mempengaruhi tampilan website Anda di hasil pencarian Google dan saat di-share ke media sosial.</p>

                <!-- SEO Cards per Page -->
                <div v-for="(setting, index) in form.settings" :key="setting.id" class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ formatPageName(setting.page_slug) }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Rute: <code class="bg-gray-100 px-1.5 py-0.5 rounded">/{{ setting.page_slug === 'home' ? '' : setting.page_slug }}</code></p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Meta Title -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                                <span :class="['text-xs font-mono', titleCharCount(setting.meta_title) > 60 ? 'text-red-500' : 'text-gray-400']">{{ titleCharCount(setting.meta_title) }} / 60</span>
                            </div>
                            <input type="text" v-model="form.settings[index].meta_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Judul halaman untuk mesin pencari..." />
                            <p class="mt-1 text-xs text-gray-400">Disarankan 50-60 karakter agar tidak terpotong di hasil pencarian.</p>
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <span :class="['text-xs font-mono', descCharCount(setting.meta_description) > 160 ? 'text-red-500' : 'text-gray-400']">{{ descCharCount(setting.meta_description) }} / 160</span>
                            </div>
                            <textarea v-model="form.settings[index].meta_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Deskripsi singkat halaman untuk mesin pencari..."></textarea>
                            <p class="mt-1 text-xs text-gray-400">Disarankan 120-160 karakter agar tampil optimal di SERP.</p>
                        </div>

                        <!-- OG Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Open Graph Image (OG Image)</label>
                            <div class="flex items-start gap-4">
                                <div v-if="setting.og_image_url" class="shrink-0">
                                    <img :src="setting.og_image_url" class="h-20 w-36 object-cover rounded-lg border border-gray-200" />
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <input type="text" v-model="form.settings[index].og_image_url" placeholder="URL gambar OG..." class="flex-1 text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" />
                                        <div class="relative overflow-hidden inline-block shrink-0">
                                            <button type="button" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-md text-sm font-medium text-gray-700 transition">
                                                Upload
                                            </button>
                                            <input type="file" @change="(e) => uploadOgImage(e, index)" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-400">Gambar yang ditampilkan saat link di-share ke sosial media. Rekomendasi: 1200×630 px.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Google Preview -->
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Preview Google Search</p>
                            <div class="space-y-1">
                                <p class="text-blue-700 text-lg font-medium truncate hover:underline cursor-pointer">
                                    {{ setting.meta_title || 'Judul Halaman — Sollu POS' }}
                                </p>
                                <p class="text-green-700 text-sm">https://sollu.local/{{ setting.page_slug === 'home' ? '' : setting.page_slug }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ setting.meta_description || 'Deskripsi halaman akan ditampilkan di sini...' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

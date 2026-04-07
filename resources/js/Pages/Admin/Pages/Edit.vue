<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import axios from 'axios';

const props = defineProps({
    slug: String,
    name: String,
    pageContents: Array,
});

const form = useForm({
    contents: JSON.parse(JSON.stringify(props.pageContents)) // Deep copy
});

const submit = () => {
    form.put(route('admin.pages.update', props.slug), {
        preserveScroll: true,
    });
};

const uploadImage = async (event, section, attrKey) => {
    const file = event.target.files[0];
    if (!file) return;

    const btn = event.target.previousElementSibling;
    const oldText = btn.innerText;
    btn.innerText = '...';

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await axios.post(route('admin.upload'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        section.attributes[attrKey] = response.data.url;
    } catch (error) {
        alert('Gagal mengupload gambar.');
    } finally {
        btn.innerText = oldText;
        event.target.value = '';
    }
};

const formatKeyName = (key) => {
    return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};
</script>

<template>
    <Head :title="`Edit Halaman ${name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Halaman: {{ name }}
                </h2>
                <button @click="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Success Message -->
                <div v-if="$page.props.flash?.success" class="p-4 bg-green-50 text-green-700 rounded-lg">
                    {{ $page.props.flash.success }}
                </div>

                <div v-for="(section, index) in form.contents" :key="section.id" class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wider">Bagian: {{ section.section_key }}</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Standard Fields -->
                        <div v-if="section.title !== null">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Title)</label>
                            <input type="text" v-model="section.title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        
                        <div v-if="section.subtitle !== null">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub-Judul (Subtitle)</label>
                            <textarea v-model="section.subtitle" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                        </div>

                        <!-- Dynamic Attributes (JSONB) -->
                        <div v-if="section.attributes" class="mt-8 border-t pt-6">
                            <h4 class="font-semibold text-gray-700 mb-4">Pengaturan Ekstra (Attributes)</h4>
                            
                            <div v-for="(attrValue, attrKey) in section.attributes" :key="attrKey" class="mb-4">
                                <!-- If attribute is an Array (e.g. features_list) -->
                                <div v-if="Array.isArray(attrValue)" class="space-y-4">
                                    <label class="block text-sm font-medium text-gray-700 capitalize">{{ formatKeyName(attrKey) }} List</label>
                                    <div v-for="(item, iIndex) in attrValue" :key="iIndex" class="p-4 border border-gray-200 rounded-lg bg-gray-50 space-y-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-bold text-gray-500">Item {{ iIndex + 1 }}</span>
                                        </div>
                                        <div v-for="(subVal, subKey) in item" :key="subKey">
                                            <label class="block text-xs font-medium text-gray-600 mb-1 capitalize">{{ formatKeyName(subKey) }}</label>
                                            <input v-if="typeof subVal === 'string'" type="text" v-model="section.attributes[attrKey][iIndex][subKey]" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <!-- Additional types can be handled here if needed -->
                                        </div>
                                    </div>
                                </div>
                                <!-- If attribute is string/text -->
                                <div v-else-if="typeof attrValue === 'string'">
                                    <label class="block text-sm font-medium text-gray-700 mb-1 capitalize">{{ formatKeyName(attrKey) }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="text" v-model="section.attributes[attrKey]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        
                                        <!-- Inline Upload Button for Image Fields -->
                                        <div v-if="attrKey.toLowerCase().includes('image') || attrKey.toLowerCase().includes('logo')" class="relative overflow-hidden inline-block">
                                            <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-md text-sm font-medium text-gray-700 transition">
                                                Upload
                                            </button>
                                            <input type="file" @change="(e) => uploadImage(e, section, attrKey)" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                        </div>
                                    </div>
                                    
                                    <div v-if="attrKey.toLowerCase().includes('image') && section.attributes[attrKey]" class="mt-2">
                                        <img :src="section.attributes[attrKey]" class="h-20 rounded-md object-contain border border-gray-200" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

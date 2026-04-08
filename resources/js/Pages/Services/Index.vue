<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Coffee, ShoppingBag, Scissors, ArrowRight, CheckCircle2 } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({})
    },
    seo: {
        type: Object,
        default: null
    }
});

const siteSettings = computed(() => usePage().props.siteSettings || {});
const activeTab = ref('fnb');
</script>

<template>
    <Head :title="seo?.meta_title || 'Layanan & Fitur'">
        <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
        <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
        <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
        <meta v-if="seo?.og_image_url" property="og:image" :content="seo.og_image_url" />
    </Head>

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-primary-50 py-20 border-b border-primary-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-gray-900 mb-6">{{ pageContents?.hero?.title || 'Solusi Disesuaikan untuk Bisnis Anda' }}</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ pageContents?.hero?.subtitle || 'Sollu POS menyediakan fitur terdedikasi untuk industri F&B, Retail, dan Jasa. Tingkatkan efisiensi dan skala bisnis Anda.' }}</p>
            </div>
        </div>

        <!-- Services Content -->
        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tab Navigation -->
                <div class="flex flex-col md:flex-row justify-center gap-4 mb-16">
                    <button @click="activeTab = 'fnb'" :class="['flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-lg transition-all', activeTab === 'fnb' ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/40' : 'bg-gray-50 text-gray-600 hover:bg-primary-50']">
                        <Coffee class="w-6 h-6" />
                        Makanan & Minuman
                    </button>
                    <button @click="activeTab = 'retail'" :class="['flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-lg transition-all', activeTab === 'retail' ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/40' : 'bg-gray-50 text-gray-600 hover:bg-primary-50']">
                        <ShoppingBag class="w-6 h-6" />
                        Toko Retail
                    </button>
                    <button @click="activeTab = 'jasa'" :class="['flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-lg transition-all', activeTab === 'jasa' ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/40' : 'bg-gray-50 text-gray-600 hover:bg-primary-50']">
                        <Scissors class="w-6 h-6" />
                        Penyedia Jasa
                    </button>
                </div>

                <!-- Tab F&B -->
                <div v-show="activeTab === 'fnb'" class="grid md:grid-cols-2 gap-12 items-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div>
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">{{ pageContents?.fnb?.title || 'Manajemen Restoran Lebih Cerdas' }}</h2>
                        <ul class="space-y-4 mb-8">
                            <li v-for="(feature, idx) in (pageContents?.fnb?.attributes?.features_list || [])" :key="idx" class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ feature.title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ feature.description }}</p>
                                </div>
                            </li>
                        </ul>
                        <a :href="pageContents?.fnb?.attributes?.button_url || siteSettings.portal_url || '#'" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS F&B Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img :src="pageContents?.fnb?.attributes?.image_url || 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'" alt="F&B POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                </div>

                <!-- Tab Retail -->
                <div v-show="activeTab === 'retail'" class="grid md:grid-cols-2 gap-12 items-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="order-2 md:order-1 relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img :src="pageContents?.retail?.attributes?.image_url || 'https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'" alt="Retail POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                    <div class="order-1 md:order-2">
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">{{ pageContents?.retail?.title || 'Kelola Stok & SKU Ribuan Item' }}</h2>
                        <ul class="space-y-4 mb-8">
                            <li v-for="(feature, idx) in (pageContents?.retail?.attributes?.features_list || [])" :key="idx" class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ feature.title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ feature.description }}</p>
                                </div>
                            </li>
                        </ul>
                        <a :href="pageContents?.retail?.attributes?.button_url || siteSettings.portal_url || '#'" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS Retail Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                </div>

                <!-- Tab Jasa -->
                <div v-show="activeTab === 'jasa'" class="grid md:grid-cols-2 gap-12 items-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div>
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">{{ pageContents?.jasa?.title || 'Kenyamanan Pelanggan Jasa Anda' }}</h2>
                        <ul class="space-y-4 mb-8">
                            <li v-for="(feature, idx) in (pageContents?.jasa?.attributes?.features_list || [])" :key="idx" class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ feature.title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ feature.description }}</p>
                                </div>
                            </li>
                        </ul>
                        <a :href="pageContents?.jasa?.attributes?.button_url || siteSettings.portal_url || '#'" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS Jasa Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img :src="pageContents?.jasa?.attributes?.image_url || 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'" alt="Service POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

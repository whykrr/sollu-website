<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ArrowRight, CheckCircle2, TrendingUp, ShieldCheck, Smartphone } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({})
    }
});

const siteSettings = computed(() => usePage().props.siteSettings || {});

// Icon map for dynamic components
const icons = {
    Smartphone,
    TrendingUp,
    ShieldCheck
};
</script>
<template>
    <Head title="Beranda" />

    <MainLayout>
        <!-- Hero Section -->
        <section class="relative bg-primary-50 pt-20 pb-32 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary-200/50 blur-3xl opacity-50"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-300/40 blur-3xl opacity-50"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-medium mb-6">
                            <span class="w-2 h-2 rounded-full bg-primary-600 animate-pulse"></span>
                            Platform POS Pilihan UMKM
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-extrabold text-gray-900 leading-tight mb-6" v-html="pageContents?.hero?.title || 'Sollu POS'">
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed">
                            {{ pageContents?.hero?.subtitle || 'Tingkatkan penjualan bisnis Anda.' }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a :href="siteSettings.portal_url || pageContents?.hero?.attributes?.button_url" class="flex items-center justify-center gap-2 bg-primary-600 text-white px-8 py-4 rounded-full font-semibold text-lg shadow-lg shadow-primary-500/30 hover:bg-primary-700 hover:shadow-primary-500/50 transition-all transform hover:-translate-y-1">
                                {{ pageContents?.hero?.attributes?.button_text || 'Coba Gratis Sekarang' }}
                                <ArrowRight class="w-5 h-5" />
                            </a>
                            <Link href="/services" class="flex items-center justify-center gap-2 bg-white text-gray-700 border border-gray-200 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                                Pelajari Fitur
                            </Link>
                        </div>
                    </div>
                    <div class="relative hidden lg:block">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary-200 to-primary-50 rounded-2xl transform rotate-3 scale-105"></div>
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sollu POS Dashboard" class="relative z-10 rounded-2xl shadow-2xl border border-white/50" />
                        
                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl z-20 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <TrendingUp class="w-6 h-6 text-green-600" />
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Penjualan Hari Ini</p>
                                <p class="text-xl font-bold text-gray-900">+ Rp 4.5M</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Overview Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">{{ pageContents?.features?.title || 'Fitur Lengkap Sollu POS' }}</h2>
                    <p class="text-lg text-gray-600">{{ pageContents?.features?.subtitle || 'Penuhi kebutuhan bisnis anda.' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Dynamic Features -->
                    <div v-for="(feature, index) in (pageContents?.features?.attributes?.features_list || [])" :key="index" class="p-8 rounded-2xl border border-gray-100 hover:border-primary-100 hover:shadow-xl hover:shadow-primary-100/50 transition-all bg-white group cursor-pointer">
                        <div class="w-14 h-14 rounded-xl bg-primary-50 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <component :is="icons[feature.icon]" v-if="icons[feature.icon]" class="w-7 h-7 text-primary-600" />
                            <CheckCircle2 v-else class="w-7 h-7 text-primary-600" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ feature.title }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

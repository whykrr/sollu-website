<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Check } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({})
    }
});

const siteSettings = computed(() => usePage().props.siteSettings || {});
</script>

<template>
    <Head title="Harga & Paket" />

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-primary-900 py-24 border-b border-primary-800 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/micro-carbon.png')] opacity-20 hidden md:block"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6">{{ pageContents?.hero?.title || 'Investasi Transparan untuk Skala Bisnis' }}</h1>
                <p class="text-xl text-primary-200 max-w-3xl mx-auto">{{ pageContents?.hero?.subtitle || 'Tanpa biaya tersembunyi. Pilih paket yang sesuai dengan ukuran bisnis Anda hari ini dan tingkatkan kapan saja.' }}</p>
            </div>
        </div>

        <!-- Pricing Content -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-20">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Basic Plan -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-heading">Pemula</h3>
                        <p class="text-gray-500 mb-6 text-sm">Cocok untuk UMKM yang baru merintis bisnis skala kecil.</p>
                        <div class="text-4xl font-extrabold text-gray-900 mb-6">
                            Rp 149<span class="text-xl text-gray-500 font-normal">.000<span class="text-base text-gray-400">/bln</span></span>
                        </div>
                        <a href="https://app.sollu.local/trial" class="w-full block text-center py-3 px-4 bg-primary-50 text-primary-700 hover:bg-primary-100 font-bold rounded-lg transition-colors mb-8">
                            Mulai Percobaan 14 Hari
                        </a>
                        <ul class="space-y-4 flex-grow mb-8">
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-green-500 shrink-0" />
                                <span class="text-gray-700 text-sm">1 Outlet (Cabang)</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-green-500 shrink-0" />
                                <span class="text-gray-700 text-sm">1 Pengguna (Kasir)</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-green-500 shrink-0" />
                                <span class="text-gray-700 text-sm">Produk Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-green-500 shrink-0" />
                                <span class="text-gray-700 text-sm">Laporan Penjualan Dasar</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Pro Plan -->
                    <div class="bg-primary-600 rounded-2xl shadow-xl shadow-primary-500/20 border border-primary-500 p-8 flex flex-col transform scale-105 z-10 relative">
                        <div class="absolute top-0 right-8 transform -translate-y-1/2">
                            <span class="bg-yellow-400 text-yellow-900 text-xs font-black uppercase tracking-wider py-1 px-3 rounded-full">Paling Laris</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2 font-heading">Profesional</h3>
                        <p class="text-primary-100 mb-6 text-sm">Untuk bisnis berkembang yang butuh analitik detail.</p>
                        <div class="text-4xl font-extrabold text-white mb-6">
                            Rp 299<span class="text-xl text-primary-200 font-normal">.000<span class="text-base text-primary-300">/bln</span></span>
                        </div>
                        <a href="https://app.sollu.local/trial" class="w-full block text-center py-3 px-4 bg-white text-primary-700 hover:bg-gray-50 font-bold rounded-lg transition-colors mb-8">
                            Pilih Paket Profesional
                        </a>
                        <ul class="space-y-4 flex-grow mb-8">
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-yellow-400 shrink-0" />
                                <span class="text-white text-sm">Hingga 5 Outlet</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-yellow-400 shrink-0" />
                                <span class="text-white text-sm">Tak Terbatas Pengguna</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-yellow-400 shrink-0" />
                                <span class="text-white text-sm">Manajemen Inventori Lanjut</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-yellow-400 shrink-0" />
                                <span class="text-white text-sm">Sistem Loyalitas Pelanggan</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-yellow-400 shrink-0" />
                                <span class="text-white text-sm">Laporan Analitik Lengkap</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-heading">Enterprise</h3>
                        <p class="text-gray-500 mb-6 text-sm">Solusi kustom untuk franchise atau bisnis multi-cabang besar.</p>
                        <div class="text-4xl font-extrabold text-gray-900 mb-6">
                            Kustom
                        </div>
                        <a href="/contact" class="w-full block text-center py-3 px-4 bg-gray-900 text-white hover:bg-gray-800 font-bold rounded-lg transition-colors mb-8">
                            Hubungi Sales
                        </a>
                        <ul class="space-y-4 flex-grow mb-8">
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-gray-700 text-sm">Outlet Tak Terbatas</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-gray-700 text-sm">Akses API & Integrasi 3rd Party</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-gray-700 text-sm">Account Manager Khusus</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <Check class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-gray-700 text-sm">Customer Support 24/7 Priority</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Trusted By -->
                <div class="mt-32 text-center">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-8">Dipercaya oleh lebih dari 5.000 bisnis di Indonesia</p>
                    <div class="flex justify-center gap-12 flex-wrap opacity-50 grayscale">
                        <!-- Placeholder logos -->
                        <div class="h-8 md:h-10 text-xl font-bold text-gray-800 tracking-tighter">BRANDONE</div>
                        <div class="h-8 md:h-10 text-xl font-bold text-gray-800 tracking-tighter">COMPANYTWO</div>
                        <div class="h-8 md:h-10 text-xl font-bold text-gray-800 tracking-tighter">GROUPTHREE</div>
                        <div class="h-8 md:h-10 text-xl font-bold text-gray-800 tracking-tighter">STUDIOFOUR</div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

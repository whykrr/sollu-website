<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Coffee, ShoppingBag, Scissors, ArrowRight, CheckCircle2 } from 'lucide-vue-next';
import { ref } from 'vue';

const activeTab = ref('fnb');
</script>

<template>
    <Head title="Layanan & Fitur" />

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-primary-50 py-20 border-b border-primary-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-gray-900 mb-6">Solusi Disesuaikan untuk Bisnis Anda</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Sollu POS menyediakan fitur terdedikasi untuk industri F&B, Retail, dan Jasa. Tingkatkan efisiensi dan skala bisnis Anda.</p>
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
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">Manajemen Restoran Lebih Cerdas</h2>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Manajemen Meja & Dine-in</h4>
                                    <p class="text-gray-600 text-sm">Visualisasi tata letak meja untuk mengelola pesanan pelanggan secara langsung.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Resep & Inventori Bahan Baku</h4>
                                    <p class="text-gray-600 text-sm">Pemotongan stok bahan otomatis untuk setiap produk terjual sehingga HPP terjaga.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Kitchen Display System (KDS)</h4>
                                    <p class="text-gray-600 text-sm">Kirim pesanan secara digital ke dapur untuk mencegah miskomunikasi koki.</p>
                                </div>
                            </li>
                        </ul>
                        <a href="https://app.sollu.local/trial" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS F&B Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="F&B POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                </div>

                <!-- Tab Retail -->
                <div v-show="activeTab === 'retail'" class="grid md:grid-cols-2 gap-12 items-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="order-2 md:order-1 relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Retail POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                    <div class="order-1 md:order-2">
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">Kelola Stok & SKU Ribuan Item</h2>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Barcode Scanning</h4>
                                    <p class="text-gray-600 text-sm">Input penjualan super cepat menggunakan pemindai barcode atau kamera device.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Peringatan Stok Tipis</h4>
                                    <p class="text-gray-600 text-sm">Notifikasi otomatis jika barang hampir habis untuk re-stock lebih terencana.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Multi Cabang Gudang</h4>
                                    <p class="text-gray-600 text-sm">Lacak perpindahan stok antar toko dan terpusat dalam satu dashboard.</p>
                                </div>
                            </li>
                        </ul>
                        <a href="https://app.sollu.local/trial" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS Retail Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                </div>

                <!-- Tab Jasa -->
                <div v-show="activeTab === 'jasa'" class="grid md:grid-cols-2 gap-12 items-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div>
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">Kenyamanan Pelanggan Jasa Anda</h2>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Penjadwalan (Booking) Booking</h4>
                                    <p class="text-gray-600 text-sm">Atur jadwal layanan pelanggan dan karyawan tanpa khawatir bentrok.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Sistem Komisi Karyawan</h4>
                                    <p class="text-gray-600 text-sm">Perhitungan bagi hasil otomatis untuk setiap pegawai layanan.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <CheckCircle2 class="w-6 h-6 text-primary-600 shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-gray-900">Member Loyalty</h4>
                                    <p class="text-gray-600 text-sm">Simpan riwayat transaksi pelanggan untuk retensi dan program loyalitas.</p>
                                </div>
                            </li>
                        </ul>
                        <a href="https://app.sollu.local/trial" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-800 transition">
                            Coba POS Jasa Gratis <ArrowRight class="w-5 h-5" />
                        </a>
                    </div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-96">
                        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Service POS" class="w-full h-full object-cover opacity-90" />
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

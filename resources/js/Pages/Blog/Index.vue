<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ChevronRight, Clock, User, ArrowRight } from 'lucide-vue-next';

// Mock Blog Posts
const featuredPost = {
    title: "Strategi Meningkatkan Penjualan F&B di Era Digital",
    excerpt: "Pelajari bagaimana mengoptimalkan sistem POS Anda untuk meningkatkan retensi pelanggan dan mempercepat proses order.",
    category: "Bisnis F&B",
    author: "Tim Redaksi Sollu",
    date: "12 Okt 2023",
    readTime: "5 min read",
    image: "https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
};

const posts = [
    {
        id: 1,
        title: "5 Fitur Aplikasi Kasir yang Wajib Dimiliki Toko Retail Anda",
        excerpt: "Jangan salah pilih aplikasi kasir. Pastikan kelima fitur ini tersedia agar toko Anda beroperasi dengan maksimal.",
        category: "Tips Retail",
        author: "Budi Santoso",
        date: "08 Okt 2023",
        readTime: "4 min read",
        image: "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
    },
    {
        id: 2,
        title: "Cara Menentukan Harga Jual yang Pas (Pricing Strategy)",
        excerpt: "Menentukan HPP dan margin keuntungan yang tepat adalah kunci bisnis jangka panjang.",
        category: "Keuangan",
        author: "Andi Wijaya",
        date: "02 Okt 2023",
        readTime: "6 min read",
        image: "https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
    },
    {
        id: 3,
        title: "Pentingnya Pembukuan Otomatis untuk Jasa Pangkas Rambut",
        excerpt: "Sistem reservasi dan komisi tak pernah semudah ini sejak adopsi digitalisasi.",
        category: "Layanan Jasa",
        author: "Tim Redaksi Sollu",
        date: "28 Sep 2023",
        readTime: "3 min read",
        image: "https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
    }
];
</script>

<template>
    <Head title="Blog & Edukasi" />

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-gray-50 py-16 border-b border-gray-100 text-center relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-gray-900 mb-6">Wawasan & Tips Bisnis</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Kumpulan artikel, studi kasus, dan panduan praktis untuk membantu Anda menumbuhkan usaha menjadi lebih besar.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Featured Post -->
                <div class="mb-20 group cursor-pointer relative overflow-hidden rounded-3xl shadow-xl">
                    <img :src="featuredPost.image" :alt="featuredPost.title" class="w-full h-[500px] object-cover transition duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full md:w-3/4 lg:w-2/3">
                        <div class="inline-flex items-center rounded-full bg-primary-600 px-3 py-1 text-sm font-semibold text-white mb-6">
                            {{ featuredPost.category }}
                        </div>
                        <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4 group-hover:text-primary-300 transition">
                            <a href="#">{{ featuredPost.title }}</a>
                        </h2>
                        <p class="text-gray-300 text-lg mb-6 line-clamp-2">{{ featuredPost.excerpt }}</p>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                            <span class="flex items-center gap-1.5"><User class="w-4 h-4" /> {{ featuredPost.author }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500 hidden sm:block"></span>
                            <span class="flex items-center gap-1.5"><Clock class="w-4 h-4" /> {{ featuredPost.date }} &middot; {{ featuredPost.readTime }}</span>
                        </div>
                    </div>
                </div>

                <!-- Latest Posts Grid -->
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold font-heading text-gray-900">Artikel Terbaru</h3>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article v-for="post in posts" :key="post.id" class="flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary-100 transition-all group">
                        <div class="relative h-56 overflow-hidden">
                            <img :src="post.image" :alt="post.title" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                            <div class="absolute top-4 left-4 inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-primary-700 shadow-sm">
                                {{ post.category }}
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition line-clamp-2">
                                <a href="#">{{ post.title }}</a>
                            </h4>
                            <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                                {{ post.excerpt }}
                            </p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                        <User class="w-5 h-5 text-gray-500" />
                                    </div>
                                    <div class="text-xs text-gray-500 flex flex-col">
                                        <span class="font-bold text-gray-900">{{ post.author }}</span>
                                        <span>{{ post.date }}</span>
                                    </div>
                                </div>
                                <a href="#" class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition">
                                    <ArrowRight class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Load More -->
                <div class="mt-16 text-center">
                    <button class="inline-flex items-center justify-center px-8 py-3 rounded-full text-primary-700 bg-primary-50 hover:bg-primary-100 font-bold transition-all">
                        Muat Lebih Banyak Artikel
                    </button>
                </div>
            </div>
        </div>
        
    </MainLayout>
</template>

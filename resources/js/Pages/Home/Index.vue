<script setup>
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import {
    ArrowRight,
    Check,
    ChevronDown,
    Send,
    Coffee,
    ShoppingBag,
    Scissors,
    Sparkles,
    ShieldCheck,
    Smartphone,
    TrendingUp,
    Store,
    Receipt,
    Users,
    Layers,
    CheckCircle2
} from "lucide-vue-next";
import { ref, computed } from "vue";

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({}),
    },
    faqs: {
        type: Array,
        default: () => [],
    },
    seo: {
        type: Object,
        default: null,
    },
});

const siteSettings = computed(() => usePage().props.siteSettings || {});

// Active tab for industry solutions
const activeSolutionTab = ref("fnb");

// FAQ accordion state
const openFaqIndex = ref(null);
const toggleFaq = (idx) => {
    openFaqIndex.value = openFaqIndex.value === idx ? null : idx;
};

// Quick Contact Form
const contactForm = useForm({
    name: "",
    business_name: "",
    phone: "",
    email: "",
    message: "",
});

const isSuccess = ref(false);

const submitContact = () => {
    contactForm.post(route("contact.store"), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
            isSuccess.value = true;
            setTimeout(() => (isSuccess.value = false), 6000);
        },
    });
};

// Differentiators items fallback
const defaultDifferentiators = [
    {
        title: "Kasir Kilat & Offline Mode",
        description: "Proses transaksi hitungan detik. Tetap lancar merekam penjualan dan mencetak struk meski internet offline.",
    },
    {
        title: "Manajemen Stok & HPP",
        description: "Bahan baku otomatis terpotong per porsi produk terjual. Kalkulasi HPP selalu presisi tanpa selisih.",
    },
    {
        title: "Multi Cabang Terintegrasi",
        description: "Pantau puluhan gerai dari satu layar. Mutasi stok dan laporan penjualan antarcabang tersaji rapi secara live.",
    },
    {
        title: "QRIS & Pembayaran Digital",
        description: "Terima seluruh e-wallet dan transfer bank. Notifikasi uang masuk tampil seketika di kasir tanpa alat EDC tambahan.",
    },
    {
        title: "Laporan Analitik Real-Time",
        description: "Ketahui menu paling laris, jam paling ramai, dan keuntungan bersih kapan pun dari ponsel Anda.",
    },
    {
        title: "Otorisasi & Keamanan Staf",
        description: "Bagi hak akses kasir dan supervisor dengan aman. Catat setiap tindakan void, diskon, dan kehadiran tim.",
    },
];

// Fallback solutions data
const solutionsData = computed(() => {
    return props.pageContents?.solutions?.attributes?.tabs || [
        {
            id: "fnb",
            label: "Makanan & Minuman (F&B)",
            title: "Operasional Restoran & Kafe Tanpa Hambatan",
            description: "Atur denah meja dine-in, kirim pesanan otomatis ke printer dapur, dan hitung bahan baku resep secara presisi.",
            image_url: "https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            features: [
                "Manajemen Meja Dine-in & Takeaway",
                "Resep Masakan & Pemotongan Bahan Otomatis",
                "Kitchen Display & Cetak Tiket Pesanan",
                "Split Bill & Gabung Tagihan Meja",
            ],
        },
        {
            id: "retail",
            label: "Toko Retail & Butik",
            title: "Kelola Puluhan Ribu SKU Barang Lebih Mudah",
            description: "Kasir kilat dengan barcode scanning, transfer inventaris antar toko, dan peringatan dini stok menipis.",
            image_url: "https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            features: [
                "Barcode Scanner via Kamera & Hardware USB",
                "Peringatan Otomatis Stok Menipis",
                "Mutasi & Penyesuaian Stok Antargudang",
                "Program Poin Member & Loyalitas",
            ],
        },
        {
            id: "jasa",
            label: "Salon & Penyedia Jasa",
            title: "Kenyamanan Booking dan Pelanggan Prioritas",
            description: "Reservasi jadwal terapis tanpa bentrok, perhitungan komisi staf otomatis, dan rekam jejak perawatan pelanggan.",
            image_url: "https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            features: [
                "Kalender Reservasi & Penjadwalan Rapi",
                "Bagi Hasil & Komisi Karyawan Otomatis",
                "Riwayat Catatan Layanan Pelanggan",
                "Pengingat Janji Temu via WhatsApp",
            ],
        },
    ];
});

const currentSolution = computed(() => {
    return solutionsData.value.find((tab) => tab.id === activeSolutionTab.value) || solutionsData.value[0];
});
</script>

<template>
    <Head :title="seo?.meta_title || 'Sollu POS — Aplikasi Kasir & Manajemen Bisnis Modern'">
        <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
        <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
        <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
        <meta v-if="seo?.og_image_url" property="og:image" :content="seo.og_image_url" />
    </Head>

    <MainLayout>
        <!-- ========================================================= -->
        <!-- 1. HERO SECTION                                           -->
        <!-- ========================================================= -->
        <section class="relative bg-white pt-12 pb-20 md:pt-20 md:pb-28 border-b border-gray-100 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center">
                    <!-- Eyebrow Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-main text-xs font-semibold uppercase tracking-wider mb-8">
                        <span class="w-2 h-2 rounded-full bg-main animate-pulse"></span>
                        {{ pageContents?.hero?.attributes?.badge || "Sistem Kasir Modern UMKM Indonesia" }}
                    </div>

                    <!-- Professional Headline -->
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-[#061a40] tracking-tight leading-[1.12] mb-8"
                        v-html="pageContents?.hero?.title || 'Kelola Penjualan & Pantau Bisnis Lebih Cepat dengan Sollu POS'"
                    ></h1>

                    <!-- Persuasive Subtitle -->
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed mb-10">
                        {{ pageContents?.hero?.subtitle || "Platform Point of Sale terpadu untuk bisnis F&B, Retail, dan Jasa. Kasir digital kilat, manajemen stok otomatis, dan analitik keuntungan real-time dalam satu genggaman." }}
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4">
                        <a
                            :href="siteSettings.cta_trial_url || pageContents?.hero?.attributes?.button_url || '#kontak'"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-main hover:bg-main-dark text-white px-8 py-4 rounded-full font-semibold text-base transition-all duration-200 shadow-md hover:shadow-lg active:scale-98"
                        >
                            {{ pageContents?.hero?.attributes?.button_text || "Coba Gratis Sekarang" }}
                            <ArrowRight class="w-4 h-4" />
                        </a>
                        <a
                            href="#solusi"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-blue-50/50 text-[#061a40] border border-blue-200/80 px-8 py-4 rounded-full font-semibold text-base transition-all duration-200 shadow-2xs"
                        >
                            {{ pageContents?.hero?.attributes?.secondary_button_text || "Pelajari Solusi" }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 2. SECTION: DIFFERENTIATORS & STATS                       -->
        <!-- ========================================================= -->
        <section id="fitur" class="py-20 md:py-28 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Top Row: Headline (Left) & Stat Counters (Right) -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12 pb-16 border-b border-gray-100">
                    <div class="max-w-xl">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight mb-4">
                            {{ pageContents?.differentiators?.title || "Kenapa Sollu POS Berbeda?" }}
                        </h2>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                            {{ pageContents?.differentiators?.subtitle || "Dirancang khusus untuk menyederhanakan operasional harian merchant dengan kecepatan tinggi, antarmuka yang mudah digunakan kasir baru, dan tanpa biaya tersembunyi." }}
                        </p>
                    </div>

                    <!-- Stat Counters -->
                    <div class="flex items-center gap-8 sm:gap-14 shrink-0">
                        <div>
                            <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#061a40] tracking-tight">
                                {{ pageContents?.differentiators?.attributes?.stats?.[0]?.value || "10k+" }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                                {{ pageContents?.differentiators?.attributes?.stats?.[0]?.label || "Mitra Bisnis" }}
                            </div>
                        </div>
                        <div class="h-10 w-px bg-gray-200"></div>
                        <div>
                            <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#061a40] tracking-tight">
                                {{ pageContents?.differentiators?.attributes?.stats?.[1]?.value || "25+" }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                                {{ pageContents?.differentiators?.attributes?.stats?.[1]?.label || "Fitur Unggulan" }}
                            </div>
                        </div>
                        <div class="h-10 w-px bg-gray-200"></div>
                        <div>
                            <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#061a40] tracking-tight">
                                {{ pageContents?.differentiators?.attributes?.stats?.[2]?.value || "99.9%" }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                                {{ pageContents?.differentiators?.attributes?.stats?.[2]?.label || "Tingkat Uptime" }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6 Feature Items Grid with brand dots -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-12 pt-16">
                    <div
                        v-for="(item, idx) in (pageContents?.differentiators?.attributes?.items || defaultDifferentiators)"
                        :key="idx"
                        class="flex flex-col"
                    >
                        <!-- Bullet icon indicator -->
                        <div class="flex items-center gap-2.5 mb-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-main shrink-0"></span>
                            <h3 class="text-lg font-bold text-[#061a40]">
                                {{ item.title }}
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed pl-5">
                            {{ item.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 3. SECTION: SHOWCASE / COMPUTER & TABLET FRAME            -->
        <!-- ========================================================= -->
        <section class="py-20 md:py-28 bg-[#fafafa] border-b border-gray-100 relative overflow-hidden">
            <!-- Background glow accents -->
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                        — {{ pageContents?.showcase?.attributes?.eyebrow || "Fitur Unggulan" }}
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight mb-4">
                        {{ pageContents?.showcase?.title || "Semua Kendali Bisnis dalam Satu Sistem" }}
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                        {{ pageContents?.showcase?.subtitle || "Gunakan layanan Sollu POS melalui tablet kasir di outlet Anda, atau pantau ringkasan omzet dan performa cabang langsung dari aplikasi smartphone dan komputer." }}
                    </p>
                </div>

                <!-- Computer Monitor & Tablet Device Mockup Frame -->
                <div class="max-w-5xl mx-auto">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border border-gray-200/90 bg-white p-3 sm:p-6 md:p-8 relative">
                        <div class="rounded-2xl overflow-hidden bg-slate-50 flex items-center justify-center">
                            <img
                                :src="pageContents?.showcase?.attributes?.image_url || '/img/showcase-devices.svg'"
                                :alt="pageContents?.showcase?.title || 'Sollu POS Komputer & Tablet Mockup'"
                                class="w-full h-auto object-contain mx-auto drop-shadow-sm transition-transform duration-500 hover:scale-[1.01]"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 4. SECTION: SOLUTIONS BY INDUSTRY                         -->
        <!-- ========================================================= -->
        <section id="solusi" class="py-20 md:py-28 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center mb-12">
                    <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                        — {{ pageContents?.solutions?.attributes?.eyebrow || "Solusi Industri" }}
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight mb-4">
                        {{ pageContents?.solutions?.title || "Didesain Khusus untuk Karakter Bisnis Anda" }}
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                        {{ pageContents?.solutions?.subtitle || "Setiap sektor memiliki dinamika kerja yang unik. Sollu POS menghadirkan fitur terdedikasi untuk F&B, Retail, dan Usaha Jasa." }}
                    </p>
                </div>

                <!-- Tab Navigation (Pill buttons) -->
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-16">
                    <button
                        v-for="tab in solutionsData"
                        :key="tab.id"
                        @click="activeSolutionTab = tab.id"
                        :class="[
                            'px-6 py-3 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2.5',
                            activeSolutionTab === tab.id
                                ? 'bg-[#061a40] text-white shadow-sm'
                                : 'bg-gray-100 text-gray-600 hover:text-[#061a40] hover:bg-gray-200/80',
                        ]"
                    >
                        <Coffee v-if="tab.id === 'fnb'" class="w-4 h-4" />
                        <ShoppingBag v-else-if="tab.id === 'retail'" class="w-4 h-4" />
                        <Scissors v-else class="w-4 h-4" />
                        {{ tab.label }}
                    </button>
                </div>

                <!-- Tab Content Panel -->
                <div class="bg-gray-50 rounded-3xl p-8 sm:p-12 border border-gray-100 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-block text-xs font-bold uppercase tracking-wider text-main bg-blue-100/70 px-3 py-1 rounded-full">
                            Solusi {{ currentSolution.label }}
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-[#061a40] tracking-tight leading-tight">
                            {{ currentSolution.title }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed text-base">
                            {{ currentSolution.description }}
                        </p>

                        <!-- Feature Checklist -->
                        <div class="space-y-3 pt-2">
                            <div
                                v-for="(feat, fIdx) in currentSolution.features"
                                :key="fIdx"
                                class="flex items-center gap-3 text-sm text-gray-800"
                            >
                                <div class="w-5 h-5 rounded-full bg-blue-100 text-main flex items-center justify-center shrink-0">
                                    <Check class="w-3.5 h-3.5" />
                                </div>
                                <span class="font-medium">{{ feat }}</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <a
                                :href="siteSettings.cta_trial_url || '#kontak'"
                                class="inline-flex items-center gap-2 bg-main hover:bg-main-dark text-white text-sm font-semibold px-6 py-3 rounded-full transition-all duration-200 shadow-sm hover:shadow"
                            >
                                Coba Fitur Ini Gratis <ArrowRight class="w-4 h-4" />
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-6">
                        <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200/80 aspect-4/3 relative">
                            <img
                                :src="currentSolution.image_url"
                                :alt="currentSolution.title"
                                class="w-full h-full object-cover transition duration-500 hover:scale-105"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 5. SECTION: PRICING                                       -->
        <!-- ========================================================= -->
        <section id="harga" class="py-20 md:py-28 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                        — {{ pageContents?.pricing_plans?.attributes?.eyebrow || "Paket & Harga" }}
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight mb-4">
                        {{ pageContents?.pricing_plans?.title || "Pilih Paket Sesuai Skala Bisnis Anda" }}
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                        {{ pageContents?.pricing_plans?.subtitle || "Harga transparan dan terjangkau untuk menopang pertumbuhan bisnis Anda dari satu gerai hingga ekspansi banyak cabang." }}
                    </p>
                </div>

                <!-- 3 Pricing Cards: Left (Basic), Middle (Brand Navy Highlighted!), Right (Enterprise) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch max-w-6xl mx-auto">
                    <div
                        v-for="(plan, pIdx) in (pageContents?.pricing_plans?.attributes?.plans || [])"
                        :key="pIdx"
                        :class="[
                            'rounded-3xl p-8 sm:p-10 flex flex-col justify-between transition-all duration-300 relative',
                            plan.is_popular
                                ? 'bg-[#061a40] text-white shadow-2xl border border-blue-900/50 transform lg:-translate-y-2'
                                : 'bg-white text-gray-950 border border-gray-200 hover:border-gray-300 shadow-xs hover:shadow-md',
                        ]"
                    >
                        <!-- Card Header -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3
                                    :class="[
                                        'text-lg font-bold tracking-tight',
                                        plan.is_popular ? 'text-white' : 'text-[#061a40]',
                                    ]"
                                >
                                    {{ plan.name }}
                                </h3>
                                <span
                                    v-if="plan.badge"
                                    :class="[
                                        'text-xs font-semibold px-3 py-1 rounded-full',
                                        plan.is_popular
                                            ? 'bg-main/30 text-blue-200 border border-blue-400/30'
                                            : 'bg-blue-50 text-main',
                                    ]"
                                >
                                    {{ plan.badge }}
                                </span>
                            </div>

                            <!-- Price Amount -->
                            <div class="mb-4">
                                <div class="flex items-baseline gap-1">
                                    <span
                                        :class="[
                                            'text-4xl sm:text-5xl font-extrabold tracking-tight',
                                            plan.is_popular ? 'text-white' : 'text-[#061a40]',
                                        ]"
                                    >
                                        {{ plan.price }}
                                    </span>
                                    <span
                                        v-if="plan.period"
                                        :class="[
                                            'text-sm font-medium',
                                            plan.is_popular ? 'text-blue-200' : 'text-gray-500',
                                        ]"
                                    >
                                        {{ plan.period }}
                                    </span>
                                </div>
                            </div>

                            <p
                                :class="[
                                    'text-xs leading-relaxed mb-8',
                                    plan.is_popular ? 'text-blue-100/80' : 'text-gray-500',
                                ]"
                            >
                                {{ plan.description }}
                            </p>

                            <!-- Features List (Checkmarks) -->
                            <div class="space-y-3.5 mb-10 border-t pt-6" :class="plan.is_popular ? 'border-blue-900/60' : 'border-gray-100'">
                                <div
                                    v-for="(feature, fIndex) in plan.features"
                                    :key="fIndex"
                                    class="flex items-start gap-3"
                                >
                                    <Check
                                        :class="[
                                            'w-4 h-4 shrink-0 mt-0.5',
                                            plan.is_popular ? 'text-cyan-400' : 'text-main',
                                        ]"
                                    />
                                    <span
                                        :class="[
                                            'text-xs sm:text-sm leading-snug',
                                            plan.is_popular ? 'text-gray-200' : 'text-gray-600',
                                        ]"
                                    >
                                        {{ feature }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-4">
                            <a
                                :href="siteSettings.portal_url || '#kontak'"
                                :class="[
                                    'w-full block text-center py-3.5 px-6 rounded-full font-semibold text-sm transition-all duration-200 shadow-xs',
                                    plan.is_popular
                                        ? 'bg-main hover:bg-main-dark text-white shadow-md'
                                        : 'bg-blue-50 text-main hover:bg-blue-100 font-semibold',
                                ]"
                            >
                                {{ plan.button_text || "Pilih Paket Ini" }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 6. SECTION: TESTIMONIALS                                  -->
        <!-- ========================================================= -->
        <section id="testimoni" class="py-20 md:py-28 bg-[#fafafa] border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                        — {{ pageContents?.testimonials?.attributes?.eyebrow || "Cerita Pelanggan" }}
                    </div>
                    <div class="flex items-baseline gap-4 mb-12">
                        <span class="text-6xl sm:text-7xl text-blue-200 font-extrabold leading-none select-none">“</span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight">
                            {{ pageContents?.testimonials?.title || "Apa Kata Klien Kami" }}
                        </h2>
                    </div>

                    <!-- Reviews Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            v-for="(review, rIdx) in (pageContents?.testimonials?.attributes?.reviews || [])"
                            :key="rIdx"
                            class="bg-white p-8 sm:p-10 rounded-3xl border border-gray-100 shadow-xs flex flex-col justify-between"
                        >
                            <p class="text-base sm:text-lg text-gray-800 leading-relaxed italic mb-8">
                                "{{ review.quote }}"
                            </p>

                            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                <img
                                    v-if="review.avatar"
                                    :src="review.avatar"
                                    :alt="review.name"
                                    class="w-12 h-12 rounded-full object-cover border border-gray-200"
                                    loading="lazy"
                                />
                                <div>
                                    <div class="font-bold text-[#061a40] text-base">
                                        {{ review.name }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium">
                                        {{ review.role }} &middot; {{ review.business }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 7. SECTION: FAQ ACCORDION PREVIEW                         -->
        <!-- ========================================================= -->
        <section v-if="faqs && faqs.length > 0" class="py-20 md:py-28 bg-white border-b border-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                        — Pertanyaan Umum
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#061a40] tracking-tight leading-tight mb-4">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p class="text-gray-600 text-base">
                        Informasi esensial untuk menjawab keraguan Anda sebelum menggunakan Sollu POS.
                    </p>
                </div>

                <div class="space-y-4">
                    <div
                        v-for="(faq, fIdx) in faqs"
                        :key="faq.id"
                        class="border rounded-2xl overflow-hidden transition-all duration-200"
                        :class="openFaqIndex === fIdx ? 'border-main/50 ring-1 ring-main/20' : 'border-gray-200'"
                    >
                        <button
                            @click="toggleFaq(fIdx)"
                            class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-hidden hover:bg-gray-50/70 transition"
                        >
                            <span
                                class="font-bold text-base transition-colors pr-4"
                                :class="openFaqIndex === fIdx ? 'text-main' : 'text-gray-900'"
                            >
                                {{ faq.question }}
                            </span>
                            <ChevronDown
                                :class="[
                                    'w-5 h-5 transition-transform duration-200 shrink-0',
                                    openFaqIndex === fIdx ? 'rotate-180 text-main' : 'text-gray-400',
                                ]"
                            />
                        </button>
                        <div
                            v-if="openFaqIndex === fIdx"
                            class="px-6 pb-6 pt-1 text-sm text-gray-600 leading-relaxed border-t border-gray-100"
                        >
                            <p class="whitespace-pre-line">{{ faq.answer }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <Link
                        href="/faq"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-main hover:text-main-dark transition"
                    >
                        Lihat Seluruh Pertanyaan di Halaman FAQ <ArrowRight class="w-4 h-4" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- 8. SECTION: CONTACT & CONSULTATION                        -->
        <!-- ========================================================= -->
        <section id="kontak" class="py-20 md:py-28 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <!-- Left Column: Context & Direct WhatsApp -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="text-xs font-semibold uppercase tracking-wider text-main">
                            — {{ pageContents?.contact_cta?.attributes?.eyebrow || "Konsultasi & Kontak" }}
                        </div>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#061a40] tracking-tight leading-tight">
                            {{ pageContents?.contact_cta?.title || "Siap Mengembangkan Usaha Anda Bersama Sollu?" }}
                        </h2>
                        <p class="text-gray-600 text-base leading-relaxed">
                            {{ pageContents?.contact_cta?.subtitle || "Tinggalkan pesan Anda atau hubungi spesialis kami langsung melalui WhatsApp untuk konsultasi pemilihan paket yang paling tepat." }}
                        </p>

                        <div class="pt-4 space-y-4">
                            <a
                                v-if="siteSettings.wa_number"
                                :href="`https://wa.me/${siteSettings.wa_number}`"
                                target="_blank"
                                class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white text-sm font-semibold px-6 py-3.5 rounded-full transition shadow-xs"
                            >
                                Chat WhatsApp Sekarang
                                <ArrowRight class="w-4 h-4" />
                            </a>

                            <div v-if="siteSettings.contact_email" class="text-xs text-gray-500">
                                Atau kirimkan email ke: <span class="font-semibold text-gray-800">{{ siteSettings.contact_email }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Consultation Form -->
                    <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-12 border border-gray-200/80 shadow-sm">
                        <h3 class="text-xl font-bold text-[#061a40] mb-2">
                            Formulir Tanya Jawab & Konsultasi
                        </h3>
                        <p class="text-xs text-gray-500 mb-8">
                            Tim representatif kami akan menghubungi Anda selambat-lambatnya dalam 1x24 jam kerja.
                        </p>

                        <!-- Success Flash Feedback -->
                        <div
                            v-if="isSuccess"
                            class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm"
                        >
                            <div class="font-bold mb-0.5">Pesan Berhasil Terkirim!</div>
                            Terima kasih! Tim konsultan Sollu POS akan segera menghubungi Anda.
                        </div>

                        <form @submit.prevent="submitContact" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="contactForm.name"
                                        required
                                        placeholder="Nama Anda"
                                        class="w-full text-sm rounded-xl border-gray-300 focus:border-main focus:ring-main px-3.5 py-2.5 transition"
                                        :class="{ 'border-red-500': contactForm.errors.name }"
                                    />
                                    <p v-if="contactForm.errors.name" class="mt-1 text-xs text-red-600">
                                        {{ contactForm.errors.name }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nama Usaha / Toko
                                    </label>
                                    <input
                                        type="text"
                                        v-model="contactForm.business_name"
                                        placeholder="Contoh: Kopi Janji Rasa"
                                        class="w-full text-sm rounded-xl border-gray-300 focus:border-main focus:ring-main px-3.5 py-2.5 transition"
                                        :class="{ 'border-red-500': contactForm.errors.business_name }"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nomor WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="tel"
                                        v-model="contactForm.phone"
                                        required
                                        placeholder="08123456789"
                                        class="w-full text-sm rounded-xl border-gray-300 focus:border-main focus:ring-main px-3.5 py-2.5 transition"
                                        :class="{ 'border-red-500': contactForm.errors.phone }"
                                    />
                                    <p v-if="contactForm.errors.phone" class="mt-1 text-xs text-red-600">
                                        {{ contactForm.errors.phone }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        v-model="contactForm.email"
                                        placeholder="nama@email.com"
                                        class="w-full text-sm rounded-xl border-gray-300 focus:border-main focus:ring-main px-3.5 py-2.5 transition"
                                        :class="{ 'border-red-500': contactForm.errors.email }"
                                    />
                                    <p v-if="contactForm.errors.email" class="mt-1 text-xs text-red-600">
                                        {{ contactForm.errors.email }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Pertanyaan atau Kebutuhan Usaha <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    v-model="contactForm.message"
                                    required
                                    rows="3"
                                    placeholder="Ceritakan jenis bisnis Anda (F&B / Retail / Jasa) dan kendala yang ingin diselesaikan..."
                                    class="w-full text-sm rounded-xl border-gray-300 focus:border-main focus:ring-main px-3.5 py-2.5 transition"
                                    :class="{ 'border-red-500': contactForm.errors.message }"
                                ></textarea>
                                <p v-if="contactForm.errors.message" class="mt-1 text-xs text-red-600">
                                    {{ contactForm.errors.message }}
                                </p>
                            </div>

                            <button
                                type="submit"
                                :disabled="contactForm.processing"
                                class="w-full bg-main hover:bg-main-dark text-white font-semibold py-3.5 px-6 rounded-full text-sm transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-50 shadow-md hover:shadow-lg"
                            >
                                <span v-if="contactForm.processing">Mengirim Pesan...</span>
                                <span v-else class="flex items-center gap-2">
                                    Kirim Pesan Sekarang <Send class="w-4 h-4" />
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

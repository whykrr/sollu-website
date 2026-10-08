<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Clock, User, ArrowRight, BookOpen } from "lucide-vue-next";

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({}),
    },
    articles: Object,
    featuredArticle: Object,
    categories: Array,
    filters: Object,
    seo: {
        type: Object,
        default: null,
    },
});

const filterByCategory = (categoryId) => {
    router.get(
        route("blog"),
        { category: categoryId || undefined },
        { preserveState: true, preserveScroll: true }
    );
};

const formatDate = (dateStr) => {
    if (!dateStr) return "";
    return new Date(dateStr).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

const readTime = (content) => {
    if (!content) return "1 mnt";
    const words = content.replace(/<[^>]*>/g, "").split(/\s+/).length;
    return Math.max(1, Math.ceil(words / 200)) + " mnt baca";
};
</script>

<template>
    <Head :title="seo?.meta_title || 'Tips & Edukasi Bisnis — Sollu POS'">
        <meta
            v-if="seo?.meta_description"
            name="description"
            :content="seo.meta_description"
        />
        <meta
            v-if="seo?.meta_title"
            property="og:title"
            :content="seo.meta_title"
        />
        <meta
            v-if="seo?.meta_description"
            property="og:description"
            :content="seo.meta_description"
        />
        <meta
            v-if="seo?.og_image_url"
            property="og:image"
            :content="seo.og_image_url"
        />
    </Head>

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-white py-16 md:py-24 border-b border-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                    — Tips & Edukasi
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-[#061a40] tracking-tight mb-6">
                    {{ pageContents?.hero?.title || "Wawasan & Panduan Mengembangkan Usaha" }}
                </h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ pageContents?.hero?.subtitle || "Kumpulan strategi praktis, manajemen stok, dan tren operasional bisnis untuk mendorong pertumbuhan usaha Anda." }}
                </p>
            </div>
        </div>

        <div class="py-16 md:py-24 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Featured Article Highlight -->
                <div
                    v-if="featuredArticle && !filters?.category"
                    class="mb-16 bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 group"
                >
                    <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                        <div class="lg:col-span-7 overflow-hidden relative min-h-[300px] lg:min-h-[440px]">
                            <img
                                :src="
                                    featuredArticle.image_url ||
                                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                                "
                                :alt="featuredArticle.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-103"
                            />
                            <div
                                v-if="featuredArticle.category"
                                class="absolute top-6 left-6 inline-flex items-center rounded-full bg-[#061a40]/90 backdrop-blur-md px-3.5 py-1 text-xs font-semibold text-white"
                            >
                                {{ featuredArticle.category.name }}
                            </div>
                        </div>

                        <div class="lg:col-span-5 p-8 sm:p-12 flex flex-col justify-between">
                            <div>
                                <div class="text-xs text-main font-bold uppercase tracking-wider mb-3">
                                    Artikel Pilihan
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-[#061a40] leading-snug mb-4 group-hover:text-main transition">
                                    <Link :href="route('blog.show', featuredArticle.slug)">
                                        {{ featuredArticle.title }}
                                    </Link>
                                </h2>
                                <p class="text-sm text-gray-600 leading-relaxed mb-6 line-clamp-3">
                                    {{ featuredArticle.excerpt }}
                                </p>
                            </div>

                            <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span class="font-medium text-gray-900">
                                        {{ featuredArticle.user?.name || "Redaksi Sollu" }}
                                    </span>
                                    <span>&middot;</span>
                                    <span>{{ formatDate(featuredArticle.published_at) }}</span>
                                    <span>&middot;</span>
                                    <span>{{ readTime(featuredArticle.content) }}</span>
                                </div>
                                <Link
                                    :href="route('blog.show', featuredArticle.slug)"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-main hover:text-main-dark transition"
                                >
                                    Baca <ArrowRight class="w-3.5 h-3.5" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex items-center gap-2 mb-12 flex-wrap">
                    <button
                        @click="filterByCategory(null)"
                        :class="[
                            'px-4 py-2 text-xs font-semibold rounded-full border transition-all duration-200',
                            !filters?.category
                                ? 'bg-main text-white border-main shadow-2xs'
                                : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:text-gray-900',
                        ]"
                    >
                        Semua Topik
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        @click="filterByCategory(cat.id)"
                        :class="[
                            'px-4 py-2 text-xs font-semibold rounded-full border transition-all duration-200',
                            filters?.category == cat.id
                                ? 'bg-main text-white border-main shadow-2xs'
                                : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:text-gray-900',
                        ]"
                    >
                        {{ cat.name }}
                        <span class="text-[10px] opacity-70 ml-1">({{ cat.articles_count }})</span>
                    </button>
                </div>

                <!-- Articles Grid (3 Columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article
                        v-for="article in articles.data"
                        :key="article.id"
                        class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col group"
                    >
                        <Link
                            :href="route('blog.show', article.slug)"
                            class="relative aspect-16/10 overflow-hidden block bg-gray-100"
                        >
                            <img
                                :src="
                                    article.image_url ||
                                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
                                "
                                :alt="article.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                v-if="article.category"
                                class="absolute top-4 left-4 inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-[11px] font-bold text-gray-900 shadow-2xs"
                            >
                                {{ article.category.name }}
                            </div>
                        </Link>

                        <div class="p-6 sm:p-7 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-[#061a40] leading-snug mb-3 group-hover:text-main transition line-clamp-2">
                                <Link :href="route('blog.show', article.slug)">
                                    {{ article.title }}
                                </Link>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-6 flex-grow line-clamp-3">
                                {{ article.excerpt }}
                            </p>

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500 mt-auto">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900">
                                        {{ article.user?.name || "Redaksi" }}
                                    </span>
                                    <span>&middot;</span>
                                    <span>{{ formatDate(article.published_at) }}</span>
                                </div>
                                <span class="font-medium text-gray-400">
                                    {{ readTime(article.content) }}
                                </span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty State -->
                <div v-if="articles.data.length === 0" class="text-center py-20 bg-white rounded-3xl border border-gray-200">
                    <p class="text-gray-500">Belum ada artikel untuk kategori ini.</p>
                </div>

                <!-- Pagination (Pill Buttons) -->
                <div v-if="articles.last_page > 1" class="mt-16 flex justify-center flex-wrap gap-2">
                    <template v-for="(link, i) in articles.links" :key="i">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            preserve-scroll
                            :class="[
                                'px-4 py-2 text-xs rounded-full border transition font-semibold',
                                link.active
                                    ? 'bg-main text-white border-main shadow-2xs'
                                    : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'
                            ]"
                            v-html="link.label"
                        />
                        <span
                            v-else
                            class="px-4 py-2 text-xs rounded-full border border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed font-medium"
                            v-html="link.label"
                        ></span>
                    </template>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

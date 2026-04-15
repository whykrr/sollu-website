<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { ChevronRight, Clock, User, ArrowRight } from "lucide-vue-next";
import { computed } from "vue";

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
        { preserveState: true, preserveScroll: true },
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
    if (!content) return "1 min";
    const words = content.replace(/<[^>]*>/g, "").split(/\s+/).length;
    return Math.max(1, Math.ceil(words / 200)) + " min read";
};
</script>

<template>
    <Head :title="seo?.meta_title || 'Blog & Edukasi'">
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
        <div
            class="bg-primary-50 py-16 border-b border-primary-100 text-center relative overflow-hidden"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1
                    class="text-4xl md:text-5xl font-heading font-extrabold text-gray-900 mb-6"
                >
                    {{ pageContents?.hero?.title || "Wawasan & Tips Bisnis" }}
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{
                        pageContents?.hero?.subtitle ||
                        "Kumpulan artikel, studi kasus, dan panduan praktis untuk membantu Anda menumbuhkan usaha menjadi lebih besar."
                    }}
                </p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Featured Post -->
                <div
                    v-if="featuredArticle && !filters?.category"
                    class="mb-20 group cursor-pointer relative overflow-hidden rounded-3xl shadow-xl"
                >
                    <Link :href="route('blog.show', featuredArticle.slug)">
                        <img
                            :src="
                                featuredArticle.image_url ||
                                'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                            "
                            :alt="featuredArticle.title"
                            class="w-full h-[500px] object-cover transition duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 p-8 md:p-12 w-full md:w-3/4 lg:w-2/3"
                        >
                            <div
                                v-if="featuredArticle.category"
                                class="inline-flex items-center rounded-full bg-primary-600 px-3 py-1 text-sm font-semibold text-white mb-6"
                            >
                                {{ featuredArticle.category.name }}
                            </div>
                            <h2
                                class="text-3xl md:text-4xl font-heading font-bold text-white mb-4 group-hover:text-primary-300 transition"
                            >
                                {{ featuredArticle.title }}
                            </h2>
                            <p class="text-gray-300 text-lg mb-6 line-clamp-2">
                                {{ featuredArticle.excerpt }}
                            </p>
                            <div
                                class="flex flex-wrap items-center gap-4 text-sm text-gray-400"
                            >
                                <span class="flex items-center gap-1.5"
                                    ><User class="w-4 h-4" />
                                    {{
                                        featuredArticle.user?.name || "Admin"
                                    }}</span
                                >
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-gray-500 hidden sm:block"
                                ></span>
                                <span class="flex items-center gap-1.5"
                                    ><Clock class="w-4 h-4" />
                                    {{
                                        formatDate(featuredArticle.published_at)
                                    }}
                                    &middot;
                                    {{
                                        readTime(featuredArticle.content)
                                    }}</span
                                >
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Category Filter -->
                <div class="flex items-center gap-3 mb-10 flex-wrap">
                    <span
                        class="text-sm font-bold text-gray-500 uppercase tracking-wider"
                        >Kategori:</span
                    >
                    <button
                        @click="filterByCategory(null)"
                        :class="[
                            'px-4 py-2 text-sm rounded-full border font-medium transition',
                            !filters?.category
                                ? 'bg-main text-white border-main shadow-md'
                                : 'bg-white text-gray-600 border-gray-200 hover:border-secondary',
                        ]"
                    >
                        Semua
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        @click="filterByCategory(cat.id)"
                        :class="[
                            'px-4 py-2 text-sm rounded-full border font-medium transition',
                            filters?.category == cat.id
                                ? 'bg-main text-white border-main shadow-md'
                                : 'bg-white text-gray-600 border-gray-200 hover:border-secondary',
                        ]"
                    >
                        {{ cat.name }}
                        <span class="text-xs opacity-70 ml-1"
                            >({{ cat.articles_count }})</span
                        >
                    </button>
                </div>

                <!-- Latest Posts Grid -->
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold font-heading text-gray-900">
                        Artikel Terbaru
                    </h3>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article
                        v-for="article in articles.data"
                        :key="article.id"
                        class="flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary-100 transition-all group"
                    >
                        <Link
                            :href="route('blog.show', article.slug)"
                            class="relative h-56 overflow-hidden block"
                        >
                            <img
                                :src="
                                    article.image_url ||
                                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
                                "
                                :alt="article.title"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                            />
                            <div
                                v-if="article.category"
                                class="absolute top-4 left-4 inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-primary-700 shadow-sm"
                            >
                                {{ article.category.name }}
                            </div>
                        </Link>
                        <div class="p-6 flex flex-col flex-grow">
                            <h4
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition line-clamp-2"
                            >
                                <Link
                                    :href="route('blog.show', article.slug)"
                                    >{{ article.title }}</Link
                                >
                            </h4>
                            <p
                                class="text-gray-600 text-sm leading-relaxed mb-6 flex-grow line-clamp-3"
                            >
                                {{ article.excerpt }}
                            </p>
                            <div
                                class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden"
                                    >
                                        <User class="w-5 h-5 text-gray-500" />
                                    </div>
                                    <div
                                        class="text-xs text-gray-500 flex flex-col"
                                    >
                                        <span class="font-bold text-gray-900">{{
                                            article.user?.name || "Admin"
                                        }}</span>
                                        <span>{{
                                            formatDate(article.published_at)
                                        }}</span>
                                    </div>
                                </div>
                                <Link
                                    :href="route('blog.show', article.slug)"
                                    class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition"
                                >
                                    <ArrowRight class="w-4 h-4" />
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty State -->
                <div
                    v-if="articles.data.length === 0"
                    class="text-center py-20"
                >
                    <p class="text-gray-500 text-lg">
                        Belum ada artikel untuk kategori ini.
                    </p>
                </div>

                <!-- Pagination -->
                <div
                    v-if="articles.last_page > 1"
                    class="mt-16 flex justify-center gap-1"
                >
                    <Link
                        v-for="link in articles.links"
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="[
                            'px-4 py-2 text-sm rounded-lg border transition',
                            link.active
                                ? 'bg-primary-600 text-white border-primary-600'
                                : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50',
                            !link.url ? 'opacity-50 cursor-not-allowed' : '',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </MainLayout>
</template>

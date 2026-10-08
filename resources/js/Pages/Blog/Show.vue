<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Clock, User, ArrowLeft, ArrowRight, Tag } from 'lucide-vue-next';

const props = defineProps({
    article: Object,
    relatedArticles: Array,
});

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};

const readTime = (content) => {
    if (!content) return '1 mnt';
    const words = content.replace(/<[^>]*>/g, '').split(/\s+/).length;
    return Math.max(1, Math.ceil(words / 200)) + ' mnt baca';
};
</script>

<template>
    <Head :title="article.title">
        <meta v-if="article.excerpt" name="description" :content="article.excerpt" />
        <meta property="og:title" :content="article.title" />
        <meta v-if="article.excerpt" property="og:description" :content="article.excerpt" />
        <meta v-if="article.image_url" property="og:image" :content="article.image_url" />
        <meta property="og:type" content="article" />
    </Head>

    <MainLayout>
        <!-- Article Header / Hero -->
        <div class="bg-white pt-12 pb-10 border-b border-gray-100">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <Link :href="route('blog')" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-main transition mb-8">
                    <ArrowLeft class="w-3.5 h-3.5" /> Kembali ke Wawasan & Tips
                </Link>

                <div v-if="article.category" class="mb-4">
                    <span class="inline-flex items-center rounded-full bg-blue-50 text-main px-3 py-1 text-xs font-bold uppercase tracking-wider">
                        {{ article.category.name }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#061a40] leading-tight tracking-tight mb-6">
                    {{ article.title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-900">{{ article.user?.name || 'Redaksi Sollu' }}</span>
                    </div>
                    <span>&middot;</span>
                    <span>{{ formatDate(article.published_at) }}</span>
                    <span>&middot;</span>
                    <span>{{ readTime(article.content) }}</span>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        <div v-if="article.image_url" class="bg-[#fafafa] py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl overflow-hidden border border-gray-200/80 shadow-xs aspect-16/9">
                    <img :src="article.image_url" :alt="article.title" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div class="py-12 md:py-16 bg-white">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Highlight Excerpt -->
                <div v-if="article.excerpt" class="mb-10 p-6 bg-blue-50/50 border-l-2 border-main rounded-r-2xl">
                    <p class="text-base sm:text-lg text-gray-800 leading-relaxed italic">
                        {{ article.excerpt }}
                    </p>
                </div>

                <!-- Tiptap Body Content -->
                <article class="tiptap max-w-none text-gray-800 text-base leading-relaxed font-sans" v-html="article.content">
                </article>

                <!-- Author & Back Section -->
                <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center font-bold text-main">
                            {{ (article.user?.name || 'S').charAt(0) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ article.user?.name || 'Redaksi Sollu' }}</p>
                            <p class="text-xs text-gray-500">Dipublikasikan pada {{ formatDate(article.published_at) }}</p>
                        </div>
                    </div>
                    <Link :href="route('blog')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-800 hover:text-main rounded-full font-semibold hover:bg-gray-200 transition text-xs">
                        <ArrowLeft class="w-3.5 h-3.5" /> Lihat Semua Artikel
                    </Link>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <div v-if="relatedArticles && relatedArticles.length > 0" class="py-16 md:py-24 bg-[#fafafa] border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-xs font-semibold uppercase tracking-wider text-main mb-2">
                    — Rekomendasi
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#061a40] leading-tight mb-8">
                    Artikel Terkait Lainnya
                </h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <article v-for="related in relatedArticles" :key="related.id" class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col group">
                        <Link :href="route('blog.show', related.slug)" class="relative aspect-16/10 overflow-hidden block bg-gray-100">
                            <img :src="related.image_url || 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'" :alt="related.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" />
                        </Link>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-[#061a40] leading-snug mb-2 group-hover:text-main transition line-clamp-2">
                                <Link :href="route('blog.show', related.slug)">{{ related.title }}</Link>
                            </h3>
                            <p class="text-xs text-gray-600 line-clamp-2 mb-4 flex-grow">{{ related.excerpt }}</p>
                            <Link :href="route('blog.show', related.slug)" class="inline-flex items-center gap-1 text-xs font-bold text-main hover:text-main-dark transition mt-auto">
                                Baca Selengkapnya <ArrowRight class="w-3.5 h-3.5" />
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

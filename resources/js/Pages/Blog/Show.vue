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
    if (!content) return '1 min';
    const words = content.replace(/<[^>]*>/g, '').split(/\s+/).length;
    return Math.max(1, Math.ceil(words / 200)) + ' min read';
};
</script>

<template>
    <Head :title="article.title" />

    <MainLayout>
        <!-- Hero Cover -->
        <div class="relative bg-gray-900">
            <img v-if="article.image_url" :src="article.image_url" :alt="article.title" class="w-full h-[400px] md:h-[500px] object-cover opacity-40" />
            <div v-else class="w-full h-[400px] md:h-[500px] bg-gradient-to-br from-primary-800 to-primary-950"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
                <div class="max-w-4xl mx-auto">
                    <Link :href="route('blog')" class="inline-flex items-center gap-1.5 text-sm text-gray-300 hover:text-white transition mb-6">
                        <ArrowLeft class="w-4 h-4" /> Kembali ke Blog
                    </Link>
                    <div v-if="article.category" class="inline-flex items-center rounded-full bg-primary-600 px-3 py-1 text-sm font-semibold text-white mb-4 ml-4">
                        <Tag class="w-3.5 h-3.5 mr-1.5" /> {{ article.category.name }}
                    </div>
                    <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white leading-tight mb-6">
                        {{ article.title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-300">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <User class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <div class="font-bold text-white">{{ article.user?.name || 'Admin' }}</div>
                                <div class="text-xs text-gray-400">Penulis</div>
                            </div>
                        </div>
                        <span class="w-1 h-1 rounded-full bg-gray-500 hidden sm:block"></span>
                        <span class="flex items-center gap-1.5"><Clock class="w-4 h-4" /> {{ formatDate(article.published_at) }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-500 hidden sm:block"></span>
                        <span>{{ readTime(article.content) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Excerpt Highlight -->
                <div v-if="article.excerpt" class="mb-10 p-6 bg-primary-50 border-l-4 border-primary-500 rounded-r-xl">
                    <p class="text-lg text-primary-900 font-medium leading-relaxed italic">{{ article.excerpt }}</p>
                </div>

                <!-- Content -->
                <article class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-blockquote:border-primary-500 prose-blockquote:text-gray-600 prose-blockquote:italic" v-html="article.content">
                </article>

                <!-- Share Section -->
                <div class="mt-16 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <User class="w-7 h-7 text-gray-500" />
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ article.user?.name || 'Admin' }}</p>
                                <p class="text-sm text-gray-500">Ditulis pada {{ formatDate(article.published_at) }}</p>
                            </div>
                        </div>
                        <Link :href="route('blog')" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-700 rounded-lg font-medium hover:bg-primary-100 transition text-sm">
                            <ArrowLeft class="w-4 h-4" /> Lihat Semua Artikel
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <div v-if="relatedArticles && relatedArticles.length > 0" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-heading font-bold text-gray-900 mb-8">Artikel Terkait</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <article v-for="related in relatedArticles" :key="related.id" class="flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary-100 transition-all group">
                        <Link :href="route('blog.show', related.slug)" class="relative h-48 overflow-hidden block">
                            <img :src="related.image_url || 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'" :alt="related.title" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                            <div v-if="related.category" class="absolute top-4 left-4 inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-primary-700 shadow-sm">
                                {{ related.category.name }}
                            </div>
                        </Link>
                        <div class="p-5 flex flex-col flex-grow">
                            <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition line-clamp-2">
                                <Link :href="route('blog.show', related.slug)">{{ related.title }}</Link>
                            </h4>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow">{{ related.excerpt }}</p>
                            <Link :href="route('blog.show', related.slug)" class="text-primary-600 font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
                                Baca Selengkapnya <ArrowRight class="w-4 h-4" />
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

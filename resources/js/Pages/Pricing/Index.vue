<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Check } from 'lucide-vue-next';
import { computed } from 'vue';

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
</script>

<template>
    <Head :title="seo?.meta_title || 'Harga & Paket'">
        <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
        <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
        <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
        <meta v-if="seo?.og_image_url" property="og:image" :content="seo.og_image_url" />
    </Head>

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
                    <div v-for="(plan, index) in (pageContents?.pricing_plans?.attributes?.plans || [])" :key="index" :class="[
                            'rounded-2xl p-8 flex flex-col',
                            plan.is_popular ? 'bg-primary-600 shadow-xl shadow-primary-500/20 border border-primary-500 transform scale-105 z-10 relative' : 'bg-white shadow-lg border border-gray-100'
                        ]">
                        
                        <!-- Popular Badge -->
                        <div v-if="plan.is_popular" class="absolute top-0 right-8 transform -translate-y-1/2">
                            <span class="bg-yellow-400 text-yellow-900 text-xs font-black uppercase tracking-wider py-1 px-3 rounded-full">Paling Laris</span>
                        </div>

                        <h3 :class="['text-xl font-bold mb-2 font-heading', plan.is_popular ? 'text-white' : 'text-gray-900']">{{ plan.name }}</h3>
                        <p :class="['mb-6 text-sm min-h-[40px]', plan.is_popular ? 'text-primary-100' : 'text-gray-500']">{{ plan.description }}</p>
                        
                        <div :class="['text-4xl font-extrabold mb-6', plan.is_popular ? 'text-white' : 'text-gray-900']">
                            {{ plan.price }}<span :class="['text-xl font-normal', plan.is_popular ? 'text-primary-200' : 'text-gray-500']">{{ plan.period }}</span>
                        </div>
                        
                        <a :href="siteSettings.portal_url || '#'" :class="[
                                'w-full block text-center py-3 px-4 font-bold rounded-lg transition-colors mb-8',
                                plan.is_popular ? 'bg-white text-primary-700 hover:bg-gray-50' : (plan.name === 'Enterprise' ? 'bg-gray-900 text-white hover:bg-gray-800' : 'bg-primary-50 text-primary-700 hover:bg-primary-100')
                            ]">
                            {{ plan.price === 'Hubungi Kami' ? 'Hubungi Sales' : 'Pilih Paket ' + plan.name }}
                        </a>
                        
                        <ul class="space-y-4 flex-grow mb-8">
                            <li v-for="(feature, fIndex) in plan.features" :key="fIndex" class="flex items-center gap-3">
                                <Check :class="['w-5 h-5 shrink-0', plan.is_popular ? 'text-yellow-400' : (plan.name === 'Enterprise' ? 'text-gray-400' : 'text-green-500')]" />
                                <span :class="['text-sm', plan.is_popular ? 'text-white' : 'text-gray-700']">{{ feature }}</span>
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

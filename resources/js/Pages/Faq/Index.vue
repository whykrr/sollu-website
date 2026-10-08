<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { ChevronDown, MessageSquare, ArrowRight } from "lucide-vue-next";
import { ref, computed } from "vue";

const props = defineProps({
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

const openFaqId = ref(null);

const toggleFaq = (id) => {
    openFaqId.value = openFaqId.value === id ? null : id;
};
</script>

<template>
    <Head :title="seo?.meta_title || 'Pertanyaan Umum (FAQ) — Sollu POS'">
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
    </Head>

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-white py-16 md:py-24 border-b border-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-xs font-semibold uppercase tracking-wider text-main mb-3">
                    — Pusat Informasi
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-[#061a40] tracking-tight mb-6">
                    Pertanyaan yang Sering Diajukan
                </h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Temukan rangkuman jawaban praktis seputar implementasi, fitur kasir digital, dan paket langganan Sollu POS.
                </p>
            </div>
        </div>

        <!-- FAQ Accordion List -->
        <div class="py-16 md:py-24 bg-[#fafafa]">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div
                        v-for="faq in faqs"
                        :key="faq.id"
                        class="bg-white rounded-2xl border overflow-hidden transition-all duration-200"
                        :class="openFaqId === faq.id ? 'border-main/50 ring-1 ring-main/20 shadow-xs' : 'border-gray-200/90 shadow-2xs'"
                    >
                        <button
                            @click="toggleFaq(faq.id)"
                            class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-hidden hover:bg-gray-50/60 transition"
                        >
                            <span
                                class="font-bold text-base md:text-lg pr-4 transition-colors"
                                :class="openFaqId === faq.id ? 'text-main' : 'text-gray-900'"
                            >
                                {{ faq.question }}
                            </span>
                            <ChevronDown
                                class="w-5 h-5 transition-transform duration-200 shrink-0"
                                :class="openFaqId === faq.id ? 'rotate-180 text-main' : 'text-gray-400'"
                            />
                        </button>

                        <!-- Answer Content with transition -->
                        <div
                            v-if="openFaqId === faq.id"
                            class="px-6 pb-6 pt-1 text-sm md:text-base text-gray-600 leading-relaxed border-t border-gray-100 font-sans"
                        >
                            <p class="whitespace-pre-line">{{ faq.answer }}</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="faqs.length === 0" class="text-center py-16 bg-white rounded-3xl border border-gray-200 p-8">
                    <p class="text-gray-500">Belum ada pertanyaan umum yang dipublikasikan.</p>
                </div>

                <!-- Help CTA Card -->
                <div class="mt-16 bg-[#061a40] text-white rounded-3xl p-8 sm:p-12 text-center relative overflow-hidden shadow-2xl border border-blue-900/50">
                    <div class="max-w-xl mx-auto">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/10 mb-6 text-white">
                            <MessageSquare class="w-6 h-6" />
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold mb-3">
                            Masih Ada Pertanyaan Lain?
                        </h3>
                        <p class="text-blue-100/80 text-sm leading-relaxed mb-8">
                            Tim konsultan kami siap menjelaskan alur kerja sistem Sollu POS yang paling sesuai dengan jenis bisnis Anda.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                            <a
                                v-if="siteSettings.wa_number"
                                :href="`https://wa.me/${siteSettings.wa_number}`"
                                target="_blank"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-[#061a40] hover:bg-blue-50 px-6 py-3.5 rounded-full font-semibold text-sm transition shadow-sm"
                            >
                                Chat WhatsApp Sekarang
                            </a>
                            <Link
                                href="/#kontak"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-main hover:bg-main-dark text-white px-6 py-3.5 rounded-full font-semibold text-sm transition shadow-sm"
                            >
                                Kirim Formulir Pertanyaan <ArrowRight class="w-4 h-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

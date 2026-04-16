<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { ChevronDown } from "lucide-vue-next";
import { ref } from "vue";

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

const openFaqId = ref(null);

const toggleFaq = (id) => {
    if (openFaqId.value === id) {
        openFaqId.value = null; // Close if clicked again
    } else {
        openFaqId.value = id; // Open new
    }
};
</script>

<template>
    <Head :title="seo?.meta_title || 'Pertanyaan Umum (FAQ) - Sollu POS'">
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
        <div class="bg-primary-900 py-20 text-center relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1
                    class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6"
                >
                    Pertanyaan Umum
                </h1>
                <p class="text-xl text-primary-200">
                    Temukan jawaban atas pertanyaan yang paling sering diajukan seputar Sollu POS.
                </p>
            </div>
        </div>

        <div class="py-20 bg-gray-50 min-h-[60vh]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div
                        v-for="faq in faqs"
                        :key="faq.id"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300"
                        :class="{'ring-2 ring-primary-500 shadow-md': openFaqId === faq.id}"
                    >
                        <button
                            @click="toggleFaq(faq.id)"
                            class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-hidden"
                            :class="openFaqId === faq.id ? 'bg-primary-50' : 'hover:bg-gray-50'"
                        >
                            <span class="font-bold text-lg text-gray-900" :class="{'text-primary-700': openFaqId === faq.id}">
                                {{ faq.question }}
                            </span>
                            <ChevronDown
                                class="w-6 h-6 text-gray-400 transition-transform duration-300 shrink-0"
                                :class="{'rotate-180 text-primary-600': openFaqId === faq.id}"
                            />
                        </button>
                        
                        <!-- Answer Body -->
                        <div
                            v-show="openFaqId === faq.id"
                            class="px-6 pb-6 pt-2 text-gray-600 leading-relaxed border-t border-gray-50"
                            style="display: none;"
                        >
                            <p class="whitespace-pre-line">{{ faq.answer }}</p>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-16 text-center bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Masih punya pertanyaan?</h3>
                    <p class="text-gray-600 mb-6">
                        Tim layanan pelanggan kami siap membantu Anda kapan saja.
                    </p>
                    <Link
                        href="/contact"
                        class="inline-block bg-linear-to-r from-main to-secondary text-white px-8 py-3 rounded-full font-bold shadow-md shadow-primary-500/30 hover:shadow-lg hover:-translate-y-0.5 transition-all"
                    >
                        Hubungi Kami
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

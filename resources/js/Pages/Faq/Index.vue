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
        <div class="bg-primary-900 py-24 text-center relative overflow-hidden">
            <!-- Playful Mesh Gradients -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[30rem] h-[30rem] rounded-full bg-primary-600/30 blur-3xl opacity-60 animate-float-organic"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[24rem] h-[24rem] rounded-full bg-blue-500/20 blur-3xl opacity-60 animate-float-organic" style="animation-delay: -2s;"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1
                    class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6 opacity-0 animate-bouncy-entry" style="animation-delay: 100ms;"
                >
                    Pertanyaan Umum
                </h1>
                <p class="text-xl text-primary-200 opacity-0 animate-bouncy-entry" style="animation-delay: 200ms;">
                    Temukan jawaban atas pertanyaan yang paling sering diajukan seputar Sollu POS.
                </p>
            </div>
        </div>

        <div class="py-20 bg-gray-50 min-h-[60vh]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="faq.id"
                        class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 opacity-0 animate-slide-up"
                        :class="{'ring-2 ring-primary-500 shadow-md transform -translate-y-1': openFaqId === faq.id}"
                        :style="`animation-delay: ${index * 100 + 300}ms;`"
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
                <div class="mt-16 text-center bg-white p-10 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 opacity-0 animate-slide-up" style="animation-delay: 600ms;">
                    <h3 class="text-3xl font-bold font-heading text-gray-900 mb-4">Masih punya pertanyaan?</h3>
                    <p class="text-gray-600 mb-8 text-lg">
                        Tim layanan pelanggan kami siap membantu Anda kapan saja.
                    </p>
                    <Link
                        href="/contact"
                        class="inline-block bg-main text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-primary-500/30 hover:bg-primary-600 hover:shadow-xl hover:-translate-y-1 transition-all transform hover:scale-105 active:scale-95"
                    >
                        Hubungi Kami
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

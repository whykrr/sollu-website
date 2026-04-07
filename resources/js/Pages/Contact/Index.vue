<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Mail, Phone, MapPin, Send } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    pageContents: {
        type: Object,
        default: () => ({})
    }
});

const siteSettings = computed(() => usePage().props.siteSettings || {});

const form = ref({
    name: '',
    business_name: '',
    phone: '',
    email: '',
    message: ''
});

const isSubmitting = ref(false);
const isSuccess = ref(false);

const submitForm = () => {
    isSubmitting.value = true;
    // Simulate submission since backend isn't ready
    setTimeout(() => {
        isSubmitting.value = false;
        isSuccess.value = true;
        form.value = { name: '', business_name: '', phone: '', email: '', message: '' };
        setTimeout(() => isSuccess.value = false, 5000);
    }, 1500);
};
</script>

<template>
    <Head title="Hubungi Kami" />

    <MainLayout>
        <!-- Header Section -->
        <div class="bg-primary-900 py-20 text-center relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6">{{ pageContents?.hero?.title || 'Mari Ciptakan Solusi Bersama' }}</h1>
                <p class="text-xl text-primary-200 max-w-2xl mx-auto">{{ pageContents?.hero?.subtitle || 'Tim kami siap membantu Anda memilih paket yang tepat atau memandu Anda dalam menggunakan Sollu POS di hari pertama.' }}</p>
            </div>
        </div>

        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-20">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Contact Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Contact Card 1 -->
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                <Phone class="w-6 h-6 text-primary-600" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Telepon & WhatsApp</h3>
                                <p class="text-gray-600 mb-3 text-sm">Konsultasi cepat via WhatsApp dengan spesialis kami.</p>
                                <a :href="'https://wa.me/' + (siteSettings?.wa_number || '6281112345678')" class="text-primary-600 font-bold hover:text-primary-800 transition">+{{ siteSettings?.wa_number || '62 811 1234 5678' }}</a>
                            </div>
                        </div>

                        <!-- Contact Card 2 -->
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                <Mail class="w-6 h-6 text-primary-600" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Email</h3>
                                <p class="text-gray-600 mb-3 text-sm">Untuk pertanyaan kerjasama atau detail teknis.</p>
                                <a :href="'mailto:' + (siteSettings?.contact_email || 'hello@sollu.local')" class="text-primary-600 font-bold hover:text-primary-800 transition">{{ siteSettings?.contact_email || 'hello@sollu.local' }}</a>
                            </div>
                        </div>

                        <!-- Contact Card 3 -->
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                <MapPin class="w-6 h-6 text-primary-600" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Kantor Pusat</h3>
                                <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ siteSettings?.office_address || "Gedung Sollu POS, Lt. 3\nJl. Sudirman No 123\nJakarta Selatan, 12190" }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-12">
                        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-2">Tinggalkan Pesan</h2>
                        <p class="text-gray-500 mb-8">Isi formulir di bawah ini dan representatif sales kami akan segera menghubungi Anda maksimal dalam 1x24 jam.</p>
                        
                        <div v-if="isSuccess" class="mb-8 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex flex-col items-center justify-center text-center">
                            <h4 class="font-bold text-lg mb-1">Pesan Berhasil Terkirim!</h4>
                            <p class="text-sm opacity-90">Terima kasih telah menghubungi kami. Kami akan segera merespons pesan Anda.</p>
                        </div>

                        <form @submit.prevent="submitForm">
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" v-model="form.name" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white" placeholder="Contoh: Budi Santoso">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bisnis / Toko</label>
                                    <input type="text" v-model="form.business_name" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white" placeholder="Contoh: Kopi Janji Kita">
                                </div>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                                    <input type="tel" v-model="form.phone" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white" placeholder="Contoh: 08123456789">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Valid</label>
                                    <input type="email" v-model="form.email" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white" placeholder="budi@example.com">
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bagaimana kami bisa membantu?</label>
                                <textarea rows="4" v-model="form.message" required class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white" placeholder="Ceritakan kebutuhan atau kendala bisnis yang sedang Anda hadapi..."></textarea>
                            </div>

                            <button type="submit" :disabled="isSubmitting" class="w-full flex justify-center items-center gap-2 bg-primary-600 text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary-500/30 hover:bg-primary-700 hover:shadow-xl transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                                <span v-if="isSubmitting">Mengirim Pesan...</span>
                                <span v-else class="flex items-center gap-2">Kirim Pesan Sekarang <Send class="w-5 h-5 ml-1" /></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

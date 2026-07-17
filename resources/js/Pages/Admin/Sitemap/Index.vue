<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Info, Download, ExternalLink, RefreshCw, CheckCircle2 } from "lucide-vue-next";

const props = defineProps({
    sitemap: Object,
});

const form = useForm({});
const isGenerating = ref(false);

const generateSitemap = () => {
    isGenerating.value = true;
    form.post(route("admin.sitemap.generate"), {
        preserveScroll: true,
        onFinish: () => (isGenerating.value = false),
    });
};
</script>

<template>
    <Head title="CMS | Sitemap Generator" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Sitemap Generator
                </h2>
                <button
                    @click="generateSitemap"
                    :disabled="isGenerating"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition disabled:opacity-50"
                >
                    <RefreshCw v-if="isGenerating" class="w-4 h-4 mr-2 animate-spin" />
                    <RefreshCw v-else class="w-4 h-4 mr-2" />
                    {{ isGenerating ? "Memproses..." : "Generate Sitemap Sekarang" }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.success"
                    class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start gap-3"
                >
                    <CheckCircle2 class="w-5 h-5 text-green-600 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-green-800">Berhasil!</h4>
                        <p class="text-sm mt-1">{{ $page.props.flash.success }}</p>
                    </div>
                </div>

                <div
                    v-if="$page.props.flash?.error"
                    class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200"
                >
                    {{ $page.props.flash.error }}
                </div>

                <!-- Info Card -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 flex gap-4 text-blue-800">
                    <Info class="w-6 h-6 shrink-0 text-blue-600" />
                    <div>
                        <h3 class="font-semibold text-blue-900">Apa itu Sitemap?</h3>
                        <p class="text-sm mt-1 text-blue-800/80">
                            Sitemap adalah file XML yang berisi daftar semua halaman di website Anda. Ini membantu mesin pencari seperti Google untuk menemukan dan mengindeks konten Anda dengan lebih cepat dan akurat. Pastikan Anda mendaftarkan URL Sitemap ini ke <a href="https://search.google.com/search-console" target="_blank" class="font-bold underline hover:text-blue-600 transition">Google Search Console</a>.
                        </p>
                    </div>
                </div>

                <!-- Sitemap Status Card -->
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">Status Sitemap</h3>
                        <p class="text-sm text-gray-500 mt-1">Daftar file sitemap yang tersedia di sistem saat ini.</p>
                    </div>
                    
                    <div class="p-6">
                        <div v-if="sitemap" class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                            {{ sitemap.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ sitemap.size }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ sitemap.last_modified }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                            <a :href="sitemap.url" target="_blank" class="inline-flex items-center text-primary-600 hover:text-primary-900 transition">
                                                <ExternalLink class="w-4 h-4 mr-1" /> Lihat
                                            </a>
                                            <a :href="sitemap.url" download class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
                                                <Download class="w-4 h-4 mr-1" /> Unduh
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div v-else class="text-center py-12 px-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada Sitemap</h3>
                            <p class="mt-1 text-sm text-gray-500">Klik tombol "Generate Sitemap Sekarang" di atas untuk membuat file sitemap.xml pertama Anda.</p>
                        </div>
                        
                        <!-- Snippet for Robot.txt -->
                        <div class="mt-6 border-t border-gray-100 pt-6" v-if="sitemap">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Tambahkan ke robots.txt</h4>
                            <p class="text-xs text-gray-500 mb-3">Salin baris di bawah ini dan tempelkan di file <code>robots.txt</code> Anda agar mesin pencari tahu lokasi sitemap.</p>
                            <div class="relative bg-gray-900 rounded-md p-3">
                                <code class="text-sm text-green-400 font-mono">Sitemap: {{ sitemap.url }}</code>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

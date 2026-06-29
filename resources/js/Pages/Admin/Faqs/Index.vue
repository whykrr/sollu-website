<template>
    <Head title="CMS | Kelola FAQ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Kelola Pertanyaan Umum (FAQ)
                </h2>
                <button
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition"
                >
                    <Plus class="w-4 h-4" /> Tambah FAQ
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200"
                >
                    {{ $page.props.flash.success }}
                </div>
                <div
                    v-if="$page.props.flash?.error"
                    class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200"
                >
                    {{ $page.props.flash.error }}
                </div>

                <!-- Empty State -->
                <div
                    v-if="faqs.length === 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center"
                >
                    <div class="flex justify-center mb-4 text-gray-300">
                        <AlertTriangle class="w-16 h-16" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        Belum ada FAQ
                    </h3>
                    <p class="text-gray-500 mb-6">
                        Tambahkan Pertanyaan Umum pertama untuk ditampilkan
                        kepada pengunjung.
                    </p>
                    <button
                        @click="openCreateModal"
                        class="px-4 py-2 bg-primary-100 text-primary-700 rounded-md font-medium hover:bg-primary-200 transition"
                    >
                        Tambah FAQ Pertama
                    </button>
                </div>

                <!-- FAQ List -->
                <div
                    v-else
                    class="bg-white shadow-sm sm:rounded-lg overflow-hidden"
                >
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16"
                                    >
                                        No
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Pertanyaan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Urutan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(faq, index) in faqs"
                                    :key="faq.id"
                                    class="hover:bg-gray-50 transition"
                                >
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ faq.question }}
                                        </div>
                                        <div
                                            class="text-sm text-gray-500 mt-1 truncate max-w-md"
                                        >
                                            {{ faq.answer }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-500 text-center"
                                    >
                                        <span
                                            class="inline-flex items-center justify-center bg-gray-100 font-bold w-8 h-8 rounded-full text-gray-700"
                                        >
                                            {{ faq.order }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="
                                                faq.is_active
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-gray-100 text-gray-800'
                                            "
                                        >
                                            {{
                                                faq.is_active
                                                    ? "Aktif"
                                                    : "Nonaktif"
                                            }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-right text-sm font-medium"
                                    >
                                        <div class="flex justify-end gap-2">
                                            <button
                                                @click="openEditModal(faq)"
                                                class="p-2 text-gray-400 hover:text-primary-600 transition"
                                                title="Edit"
                                            >
                                                <Pencil class="w-4 h-4" />
                                            </button>
                                            <button
                                                @click="deleteFaq(faq)"
                                                class="p-2 text-gray-400 hover:text-red-600 transition"
                                                title="Hapus"
                                            >
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <FaqForm :show="isModalOpen" :faq="currentFaq" @close="closeModal" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Plus, Pencil, Trash2, AlertTriangle } from "lucide-vue-next";
import { ref } from "vue";
import FaqForm from "./FaqForm.vue";

const props = defineProps({
    faqs: Array,
});

const isModalOpen = ref(false);
const currentFaq = ref(null);

const openCreateModal = () => {
    currentFaq.value = null;
    isModalOpen.value = true;
};

const openEditModal = (faq) => {
    currentFaq.value = faq;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const deleteFaq = (faq) => {
    if (confirm(`Yakin ingin menghapus Pertanyaan Umum: "${faq.question}"?`)) {
        router.delete(route("admin.faqs.destroy", faq.id), {
            preserveScroll: true,
        });
    }
};
</script>

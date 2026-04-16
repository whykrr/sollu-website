<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { Plus, Pencil, Trash2, X, AlertTriangle } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({
    faqs: Array,
});

const isModalOpen = ref(false);
const isEditMode = ref(false);
const currentFaqId = ref(null);

const form = useForm({
    question: "",
    answer: "",
    order: 0,
    is_active: true,
});

const openCreateModal = () => {
    isEditMode.value = false;
    currentFaqId.value = null;
    form.reset();
    isModalOpen.value = true;
};

const openEditModal = (faq) => {
    isEditMode.value = true;
    currentFaqId.value = faq.id;
    form.question = faq.question;
    form.answer = faq.answer;
    form.order = faq.order;
    form.is_active = faq.is_active;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route("admin.faqs.update", currentFaqId.value), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route("admin.faqs.store"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
};

const deleteFaq = (faq) => {
    if (confirm(`Yakin ingin menghapus Pertanyaan Umum: "${faq.question}"?`)) {
        router.delete(route("admin.faqs.destroy", faq.id), {
            preserveScroll: true,
        });
    }
};
</script>

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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada FAQ</h3>
                    <p class="text-gray-500 mb-6">
                        Tambahkan Pertanyaan Umum pertama untuk ditampilkan kepada pengunjung.
                    </p>
                    <button
                        @click="openCreateModal"
                        class="px-4 py-2 bg-primary-100 text-primary-700 rounded-md font-medium hover:bg-primary-200 transition"
                    >
                        Tambah FAQ Pertama
                    </button>
                </div>

                <!-- FAQ List -->
                <div v-else class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(faq, index) in faqs" :key="faq.id" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ faq.question }}</div>
                                    <div class="text-sm text-gray-500 mt-1 truncate max-w-md">{{ faq.answer }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                    <span class="inline-flex items-center justify-center bg-gray-100 font-bold w-8 h-8 rounded-full text-gray-700">
                                        {{ faq.order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                        :class="faq.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                        {{ faq.is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <button @click="openEditModal(faq)" class="p-2 text-gray-400 hover:text-primary-600 transition" title="Edit">
                                            <Pencil class="w-4 h-4" />
                                        </button>
                                        <button @click="deleteFaq(faq)" class="p-2 text-gray-400 hover:text-red-600 transition" title="Hapus">
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

        <!-- Form Modal -->
        <Modal :show="isModalOpen" @close="closeModal" maxWidth="2xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ isEditMode ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                        <input
                            type="text"
                            v-model="form.question"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Tuliskan pertanyaan..."
                        />
                        <div v-if="form.errors.question" class="mt-1 text-sm text-red-600">{{ form.errors.question }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                        <textarea
                            v-model="form.answer"
                            required
                            rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 leading-relaxed"
                            placeholder="Tuliskan jawaban yang informatif..."
                        ></textarea>
                        <div v-if="form.errors.answer" class="mt-1 text-sm text-red-600">{{ form.errors.answer }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil</label>
                            <input
                                type="number"
                                v-model="form.order"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            />
                            <p class="mt-1 text-xs text-gray-500">Angka yang lebih kecil akan tampil lebih dulu di frontend.</p>
                            <div v-if="form.errors.order" class="mt-1 text-sm text-red-600">{{ form.errors.order }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Penayangan</label>
                            <div class="mt-2 flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    v-model="form.is_active"
                                    class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 h-5 w-5"
                                />
                                <label for="is_active" class="ml-2 text-sm text-gray-700 cursor-pointer text-base">Aktif ditayangkan</label>
                            </div>
                            <div v-if="form.errors.is_active" class="mt-1 text-sm text-red-600">{{ form.errors.is_active }}</div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md font-medium text-sm hover:bg-gray-50 transition"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-primary-600 text-white rounded-md font-bold text-sm hover:bg-primary-700 transition disabled:opacity-50"
                        >
                            {{ isEditMode ? 'Simpan Perubahan' : 'Tambah FAQ' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<template>
    <Modal :show="show" :closeable="false" @close="close" maxWidth="2xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">
                    {{ isEditMode ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
                </h3>
                <button @click="close" class="text-gray-400 hover:text-gray-600 transition">
                    <X class="w-5 h-5" />
                </button>
            </div>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                    <input
                        type="text"
                        id="question"
                        v-model="form.question"
                        required
                        aria-label="Pertanyaan"
                        autocomplete="off"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Tuliskan pertanyaan..."
                    />
                    <div v-if="form.errors.question" class="mt-1 text-sm text-red-600">{{ form.errors.question }}</div>
                </div>

                <div class="mb-4">
                    <label for="answer" class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                    <textarea
                        id="answer"
                        v-model="form.answer"
                        required
                        rows="4"
                        aria-label="Jawaban"
                        autocomplete="off"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 leading-relaxed"
                        placeholder="Tuliskan jawaban yang informatif..."
                    ></textarea>
                    <div v-if="form.errors.answer" class="mt-1 text-sm text-red-600">{{ form.errors.answer }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil</label>
                        <input
                            type="number"
                            id="order"
                            v-model="form.order"
                            aria-label="Urutan Tampil"
                            autocomplete="off"
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
                                aria-label="Status Penayangan"
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
                        @click="close"
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
</template>

<script setup>
import { computed, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { X } from "lucide-vue-next";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    faq: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close"]);

const isEditMode = computed(() => !!props.faq);

const form = useForm({
    question: "",
    answer: "",
    order: 0,
    is_active: true,
});

watch(
    () => props.show,
    (isOpen) => {
        if (isOpen) {
            if (props.faq) {
                form.question = props.faq.question;
                form.answer = props.faq.answer;
                form.order = props.faq.order;
                form.is_active = props.faq.is_active;
            } else {
                form.reset();
                form.clearErrors();
            }
        }
    }
);

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route("admin.faqs.update", props.faq.id), {
            preserveScroll: true,
            onSuccess: () => close(),
        });
    } else {
        form.post(route("admin.faqs.store"), {
            preserveScroll: true,
            onSuccess: () => close(),
        });
    }
};

const close = () => {
    form.reset();
    form.clearErrors();
    emit("close");
};
</script>

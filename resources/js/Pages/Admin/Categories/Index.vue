<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, X, Check } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    categories: Array,
});

// New category form
const newCategoryName = ref('');
const showAddForm = ref(false);
const addForm = useForm({ name: '' });

const addCategory = () => {
    addForm.name = newCategoryName.value;
    addForm.post(route('admin.categories.store'), {
        preserveScroll: true,
        onSuccess: () => {
            newCategoryName.value = '';
            showAddForm.value = false;
        },
    });
};

// Edit inline
const editingId = ref(null);
const editName = ref('');

const startEdit = (category) => {
    editingId.value = category.id;
    editName.value = category.name;
};

const cancelEdit = () => {
    editingId.value = null;
    editName.value = '';
};

const saveEdit = (category) => {
    router.put(route('admin.categories.update', category.id), { name: editName.value }, {
        preserveScroll: true,
        onSuccess: () => cancelEdit(),
    });
};

const deleteCategory = (category) => {
    if (confirm(`Yakin ingin menghapus kategori "${category.name}"? Kategori ini hanya bisa dihapus jika tidak memiliki artikel.`)) {
        router.delete(route('admin.categories.destroy', category.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Kelola Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Kelola Kategori Artikel
                </h2>
                <button @click="showAddForm = !showAddForm" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition">
                    <Plus class="w-4 h-4" /> Tambah Kategori
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash?.error" class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
                    {{ $page.props.flash.error }}
                </div>

                <!-- Add Category Form -->
                <div v-if="showAddForm" class="mb-6 bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Tambah Kategori Baru</h3>
                    <form @submit.prevent="addCategory" class="flex gap-3">
                        <input type="text" v-model="newCategoryName" required placeholder="Nama kategori..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" />
                        <button type="submit" :disabled="addForm.processing" class="px-4 py-2 bg-primary-600 text-white rounded-md font-bold text-sm hover:bg-primary-700 transition disabled:opacity-50">
                            Simpan
                        </button>
                        <button type="button" @click="showAddForm = false" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200 transition">
                            Batal
                        </button>
                    </form>
                    <div v-if="addForm.errors.name" class="mt-2 text-sm text-red-600">{{ addForm.errors.name }}</div>
                </div>

                <!-- Categories Table -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Artikel</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <!-- Inline edit mode -->
                                    <div v-if="editingId === category.id" class="flex items-center gap-2">
                                        <input type="text" v-model="editName" @keyup.enter="saveEdit(category)" @keyup.escape="cancelEdit" class="flex-1 text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" />
                                        <button @click="saveEdit(category)" class="p-1 text-green-600 hover:bg-green-50 rounded transition"><Check class="w-4 h-4" /></button>
                                        <button @click="cancelEdit" class="p-1 text-gray-400 hover:bg-gray-100 rounded transition"><X class="w-4 h-4" /></button>
                                    </div>
                                    <!-- Display mode -->
                                    <span v-else class="text-sm font-medium text-gray-900">{{ category.name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ category.slug }}</code>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                                        {{ category.articles_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div v-if="editingId !== category.id" class="flex items-center justify-end gap-2">
                                        <button @click="startEdit(category)" class="p-2 text-gray-400 hover:text-primary-600 transition" title="Edit">
                                            <Pencil class="w-4 h-4" />
                                        </button>
                                        <button @click="deleteCategory(category)" class="p-2 text-gray-400 hover:text-red-600 transition" title="Hapus">
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="categories.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada kategori. Klik "Tambah Kategori" untuk memulai.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

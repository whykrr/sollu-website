<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { Plus, Pencil, Trash2, X, Check, Mail } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({
    users: Array,
});

const showAddForm = ref(false);

const addForm = useForm({
    name: "",
    email: "",
    role: "creator",
});

const addUser = () => {
    addForm.post(route("admin.users.store"), {
        onSuccess: () => {
            addForm.reset();
            showAddForm.value = false;
        },
    });
};

const editingId = ref(null);
const editForm = useForm({
    name: "",
    email: "",
    role: "",
});

const startEdit = (user) => {
    editingId.value = user.id;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.role = user.role;
};

const cancelEdit = () => {
    editingId.value = null;
    editForm.reset();
    editForm.clearErrors();
};

const saveEdit = (user) => {
    editForm.put(route("admin.users.update", user.id), {
        onSuccess: () => cancelEdit(),
    });
};

const deleteUser = (user) => {
    if (
        confirm(
            `Yakin ingin menghapus pengguna "${user.name}"? Data artikel yang dibuat pengguna ini tidak akan terhapus, tetapi penulisnya mungkin menjadi tidak diketahui.`,
        )
    ) {
        router.delete(route("admin.users.destroy", user.id));
    }
};

const roleBadgeClass = (role) => {
    switch (role) {
        case "superadmin":
            return "bg-purple-100 text-purple-800";
        case "admin":
            return "bg-blue-100 text-blue-800";
        default:
            return "bg-gray-100 text-gray-800";
    }
};

const formatRole = (role) => {
    switch (role) {
        case "superadmin":
            return "Super Admin";
        case "admin":
            return "Admin";
        default:
            return "Creator";
    }
};
</script>

<template>
    <Head title="CMS | Kelola Pengguna" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Kelola Pengguna & Hak Akses
                </h2>
                <button
                    @click="showAddForm = !showAddForm"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition"
                >
                    <Plus class="w-4 h-4" /> Tambah Pengguna
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

                <!-- Add User Form -->
                <div
                    v-if="showAddForm"
                    class="mb-6 bg-white shadow sm:rounded-lg p-6 border-t-4 border-primary-500"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                Tambah Pengguna Baru
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Undangan link reset password akan dikirimkan ke
                                email untuk mengatur password awal.
                            </p>
                        </div>
                        <button
                            @click="showAddForm = false"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <form @submit.prevent="addUser" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Nama Lengkap</label
                                >
                                <input
                                    type="text"
                                    v-model="addForm.name"
                                    required
                                    class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="Cth: Budi Santoso"
                                />
                                <div
                                    v-if="addForm.errors.name"
                                    class="mt-1 text-xs text-red-600"
                                >
                                    {{ addForm.errors.name }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Email
                                    <span
                                        class="text-xs text-gray-400 font-normal"
                                        >(Untuk Undangan)</span
                                    ></label
                                >
                                <input
                                    type="email"
                                    v-model="addForm.email"
                                    required
                                    class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="budi@example.com"
                                />
                                <div
                                    v-if="addForm.errors.email"
                                    class="mt-1 text-xs text-red-600"
                                >
                                    {{ addForm.errors.email }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Hak Akses (Role)</label
                                >
                                <select
                                    v-model="addForm.role"
                                    class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                >
                                    <option value="creator">
                                        Creator (Hanya Blog)
                                    </option>
                                    <option value="admin">
                                        Admin (CMS & Pengaturan)
                                    </option>
                                    <option value="superadmin">
                                        Super Admin (Akses Penuh)
                                    </option>
                                </select>
                                <div
                                    v-if="addForm.errors.role"
                                    class="mt-1 text-xs text-red-600"
                                >
                                    {{ addForm.errors.role }}
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button
                                type="button"
                                @click="showAddForm = false"
                                class="px-4 py-2 mr-3 text-sm text-gray-600 hover:text-gray-900 font-medium"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                :disabled="addForm.processing"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 text-white rounded-md font-bold text-sm hover:bg-primary-700 transition disabled:opacity-50"
                            >
                                <Mail class="w-4 h-4" />
                                {{
                                    addForm.processing
                                        ? "Mengirim..."
                                        : "Kirim Undangan"
                                }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3"
                                >
                                    Pengguna
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3"
                                >
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Role
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
                                v-for="user in users"
                                :key="user.id"
                                class="hover:bg-gray-50 transition"
                            >
                                <!-- DISPLAY MODE -->
                                <template v-if="editingId !== user.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ user.name }}
                                        </div>
                                        <div
                                            v-if="
                                                user.id ===
                                                $page.props.auth.user.id
                                            "
                                            class="text-xs text-primary-600 font-semibold"
                                        >
                                            (Anda)
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                    >
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="[
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                roleBadgeClass(user.role),
                                            ]"
                                        >
                                            {{ formatRole(user.role) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                        <div
                                            class="flex items-center justify-end gap-3"
                                        >
                                            <button
                                                @click="startEdit(user)"
                                                class="text-gray-400 hover:text-primary-600 transition"
                                                title="Edit"
                                            >
                                                <Pencil class="w-4 h-4" />
                                            </button>
                                            <button
                                                v-if="
                                                    user.id !==
                                                    $page.props.auth.user.id
                                                "
                                                @click="deleteUser(user)"
                                                class="text-gray-400 hover:text-red-600 transition"
                                                title="Hapus"
                                            >
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </template>

                                <!-- EDIT MODE -->
                                <template v-else>
                                    <td class="px-4 py-3 align-top">
                                        <input
                                            type="text"
                                            v-model="editForm.name"
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                        />
                                        <div
                                            v-if="editForm.errors.name"
                                            class="mt-1 text-xs text-red-600"
                                        >
                                            {{ editForm.errors.name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <input
                                            type="email"
                                            v-model="editForm.email"
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                        />
                                        <div
                                            v-if="editForm.errors.email"
                                            class="mt-1 text-xs text-red-600"
                                        >
                                            {{ editForm.errors.email }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <select
                                            v-model="editForm.role"
                                            :disabled="
                                                user.id ===
                                                $page.props.auth.user.id
                                            "
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-gray-100 disabled:text-gray-500"
                                        >
                                            <option value="creator">
                                                Creator
                                            </option>
                                            <option value="admin">Admin</option>
                                            <option value="superadmin">
                                                Super Admin
                                            </option>
                                        </select>
                                        <div
                                            v-if="
                                                user.id ===
                                                $page.props.auth.user.id
                                            "
                                            class="text-[10px] text-gray-400 mt-1"
                                        >
                                            Anda tidak bisa merubah role diri
                                            sendiri.
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 mt-1"
                                        >
                                            <button
                                                @click="saveEdit(user)"
                                                :disabled="editForm.processing"
                                                class="p-1 text-green-600 hover:bg-green-50 rounded transition disabled:opacity-50"
                                            >
                                                <Check class="w-5 h-5" />
                                            </button>
                                            <button
                                                @click="cancelEdit"
                                                class="p-1 text-gray-400 hover:bg-gray-100 rounded transition"
                                            >
                                                <X class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

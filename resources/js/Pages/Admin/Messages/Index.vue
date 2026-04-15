<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import {
    Mail,
    MailOpen,
    Trash2,
    Eye,
    Search,
    Inbox,
    MessageSquare,
    CheckCircle2,
    AlertCircle,
    Reply,
} from "lucide-vue-next";
import { ref, watch } from "vue";

const props = defineProps({
    messages: Object,
    filters: Object,
    stats: Object,
});

const search = ref(props.filters?.search || "");
let searchTimeout = null;

watch(search, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            route("admin.messages.index"),
            {
                search: value || undefined,
                status: props.filters?.status || undefined,
            },
            { preserveState: true, preserveScroll: true },
        );
    }, 400);
});

const filterByStatus = (status) => {
    router.get(
        route("admin.messages.index"),
        {
            status: status || undefined,
            search: search.value || undefined,
        },
        { preserveState: true },
    );
};

const toggleRead = (message) => {
    router.patch(route("admin.messages.toggleRead", message.id), {}, {
        preserveState: true,
        preserveScroll: true,
    });
};

const deleteMessage = (message) => {
    if (confirm(`Yakin ingin menghapus pesan dari "${message.name}"?`)) {
        router.delete(route("admin.messages.destroy", message.id));
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return "-";
    return new Date(dateStr).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const timeAgo = (dateStr) => {
    if (!dateStr) return "";
    const now = new Date();
    const date = new Date(dateStr);
    const diff = Math.floor((now - date) / 1000);

    if (diff < 60) return "Baru saja";
    if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
    if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;
    return formatDate(dateStr);
};
</script>

<template>
    <Head title="CMS | Pesan Masuk" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Pesan Masuk (Leads)
                </h2>
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

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <button
                        @click="filterByStatus(null)"
                        :class="[
                            'p-4 rounded-xl border-2 text-left transition-all',
                            !filters?.status
                                ? 'border-primary-500 bg-primary-50 shadow-md'
                                : 'border-gray-200 bg-white hover:border-gray-300',
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center"
                            >
                                <MessageSquare
                                    class="w-5 h-5 text-primary-600"
                                />
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ stats.total }}
                                </p>
                                <p class="text-xs text-gray-500">Total Pesan</p>
                            </div>
                        </div>
                    </button>
                    <button
                        @click="filterByStatus('unread')"
                        :class="[
                            'p-4 rounded-xl border-2 text-left transition-all',
                            filters?.status === 'unread'
                                ? 'border-amber-500 bg-amber-50 shadow-md'
                                : 'border-gray-200 bg-white hover:border-gray-300',
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center"
                            >
                                <AlertCircle class="w-5 h-5 text-amber-600" />
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ stats.unread }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Belum Dibaca
                                </p>
                            </div>
                        </div>
                    </button>
                    <button
                        @click="filterByStatus('read')"
                        :class="[
                            'p-4 rounded-xl border-2 text-left transition-all',
                            filters?.status === 'read'
                                ? 'border-green-500 bg-green-50 shadow-md'
                                : 'border-gray-200 bg-white hover:border-gray-300',
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center"
                            >
                                <CheckCircle2 class="w-5 h-5 text-green-600" />
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ stats.read }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Sudah Dibaca
                                </p>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- Search -->
                <div class="mb-6">
                    <div class="relative">
                        <Search
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                        />
                        <input
                            type="text"
                            v-model="search"
                            placeholder="Cari berdasarkan nama, bisnis, email, atau telepon..."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm bg-white"
                        />
                    </div>
                </div>

                <!-- Messages Table -->
                <div
                    class="bg-white shadow-sm sm:rounded-lg overflow-hidden"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Pengirim
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Pesan
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Waktu
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
                                v-for="msg in messages.data"
                                :key="msg.id"
                                :class="[
                                    'transition',
                                    !msg.is_read
                                        ? 'bg-primary-50/40 hover:bg-primary-50'
                                        : 'hover:bg-gray-50',
                                ]"
                            >
                                <td class="px-6 py-4">
                                    <div>
                                        <div
                                            :class="[
                                                'text-sm font-bold',
                                                !msg.is_read
                                                    ? 'text-gray-900'
                                                    : 'text-gray-700',
                                            ]"
                                        >
                                            {{ msg.name }}
                                        </div>
                                        <div
                                            class="text-xs text-gray-500 mt-0.5"
                                        >
                                            {{ msg.business_name || "-" }}
                                        </div>
                                        <div
                                            class="text-xs text-gray-400 mt-0.5"
                                        >
                                            {{ msg.phone }}
                                            <span v-if="msg.email">
                                                · {{ msg.email }}</span
                                            >
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <p
                                        :class="[
                                            'text-sm line-clamp-2',
                                            !msg.is_read
                                                ? 'text-gray-800 font-medium'
                                                : 'text-gray-600',
                                        ]"
                                    >
                                        {{ msg.message }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            v-if="msg.is_read"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 w-fit"
                                        >
                                            <MailOpen class="w-3.5 h-3.5" />
                                            Dibaca
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 w-fit"
                                        >
                                            <Mail class="w-3.5 h-3.5" />
                                            Baru
                                        </span>
                                        <span
                                            v-if="msg.replied_at"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700 w-fit"
                                        >
                                            <Reply class="w-3.5 h-3.5" />
                                            Dibalas
                                        </span>
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
                                >
                                    {{ timeAgo(msg.created_at) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-1"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'admin.messages.show',
                                                    msg.id,
                                                )
                                            "
                                            class="p-2 text-gray-400 hover:text-primary-600 transition"
                                            title="Lihat Detail"
                                        >
                                            <Eye class="w-4 h-4" />
                                        </Link>
                                        <button
                                            @click="toggleRead(msg)"
                                            class="p-2 text-gray-400 hover:text-amber-600 transition"
                                            :title="
                                                msg.is_read
                                                    ? 'Tandai Belum Dibaca'
                                                    : 'Tandai Sudah Dibaca'
                                            "
                                        >
                                            <MailOpen
                                                v-if="msg.is_read"
                                                class="w-4 h-4"
                                            />
                                            <Mail v-else class="w-4 h-4" />
                                        </button>
                                        <button
                                            @click="deleteMessage(msg)"
                                            class="p-2 text-gray-400 hover:text-red-600 transition"
                                            title="Hapus"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="messages.data.length === 0">
                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center"
                                >
                                    <Inbox
                                        class="w-12 h-12 text-gray-300 mx-auto mb-3"
                                    />
                                    <p class="text-gray-500 font-medium">
                                        Belum ada pesan masuk.
                                    </p>
                                    <p class="text-gray-400 text-sm mt-1">
                                        Pesan dari formulir kontak akan muncul
                                        di sini.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div
                        v-if="messages.last_page > 1"
                        class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                    >
                        <p class="text-sm text-gray-500">
                            Menampilkan
                            <span class="font-medium">{{
                                messages.from || 0
                            }}</span>
                            sampai
                            <span class="font-medium">{{
                                messages.to || 0
                            }}</span>
                            dari
                            <span class="font-medium">{{
                                messages.total
                            }}</span>
                            pesan
                        </p>

                        <div class="flex flex-wrap gap-1">
                            <Link
                                v-for="link in messages.links"
                                :key="link.label"
                                :href="link.url || '#'"
                                preserve-scroll
                                preserve-state
                                :class="[
                                    'px-3 py-1 text-sm rounded border transition whitespace-nowrap',
                                    link.active
                                        ? 'bg-primary-600 text-white border-primary-600'
                                        : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50',
                                    !link.url
                                        ? 'opacity-50 cursor-not-allowed'
                                        : '',
                                ]"
                                v-html="link.label"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

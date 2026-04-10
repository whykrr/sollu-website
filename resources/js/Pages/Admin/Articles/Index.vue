<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { Pencil, Trash2, Plus, Eye, EyeOff } from "lucide-vue-next";

const props = defineProps({
    articles: Object,
    categories: Array,
    filters: Object,
});

const filterByCategory = (categoryId) => {
    router.get(
        route("admin.articles.index"),
        { category: categoryId || undefined },
        { preserveState: true },
    );
};

const deleteArticle = (article) => {
    if (confirm(`Yakin ingin menghapus artikel "${article.title}"?`)) {
        router.delete(route("admin.articles.destroy", article.id));
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return "-";
    return new Date(dateStr).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
};
</script>

<template>
    <Head title="CMS | Kelola Artikel" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Kelola Artikel Blog
                </h2>
                <Link
                    :href="route('admin.articles.create')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition"
                >
                    <Plus class="w-4 h-4" /> Tulis Artikel Baru
                </Link>
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

                <!-- Filter -->
                <div class="mb-6 flex items-center gap-3 flex-wrap">
                    <span class="text-sm font-medium text-gray-500"
                        >Filter:</span
                    >
                    <button
                        @click="filterByCategory(null)"
                        :class="[
                            'px-3 py-1.5 text-sm rounded-full border transition',
                            !filters?.category
                                ? 'bg-primary-600 text-white border-primary-600'
                                : 'bg-white text-gray-600 border-gray-300 hover:border-primary-300',
                        ]"
                    >
                        Semua
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        @click="filterByCategory(cat.id)"
                        :class="[
                            'px-3 py-1.5 text-sm rounded-full border transition',
                            filters?.category == cat.id
                                ? 'bg-primary-600 text-white border-primary-600'
                                : 'bg-white text-gray-600 border-gray-300 hover:border-primary-300',
                        ]"
                    >
                        {{ cat.name }}
                    </button>
                </div>

                <!-- Articles Table -->
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Artikel
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Kategori
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Tanggal
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
                                v-for="article in articles.data"
                                :key="article.id"
                                class="hover:bg-gray-50 transition"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img
                                            v-if="article.image_url"
                                            :src="article.image_url"
                                            class="w-16 h-12 rounded-lg object-cover border border-gray-200"
                                        />
                                        <div
                                            v-else
                                            class="w-16 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs"
                                        >
                                            No Img
                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-bold text-gray-900 line-clamp-1"
                                            >
                                                {{ article.title }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                oleh
                                                {{
                                                    article.user?.name ||
                                                    "Unknown"
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        v-if="article.category"
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700"
                                    >
                                        {{ article.category.name }}
                                    </span>
                                    <span v-else class="text-xs text-gray-400"
                                        >Tanpa Kategori</span
                                    >
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        v-if="article.published_at"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700"
                                    >
                                        <Eye class="w-3.5 h-3.5" /> Published
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700"
                                    >
                                        <EyeOff class="w-3.5 h-3.5" /> Draft
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{
                                        formatDate(
                                            article.published_at ||
                                                article.created_at,
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <template
                                            v-if="
                                                [
                                                    'superadmin',
                                                    'admin',
                                                ].includes(
                                                    $page.props.auth.user.role,
                                                ) ||
                                                $page.props.auth.user.id ===
                                                    article.user_id
                                            "
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'admin.articles.edit',
                                                        article.id,
                                                    )
                                                "
                                                class="p-2 text-gray-400 hover:text-primary-600 transition"
                                                title="Edit"
                                            >
                                                <Pencil class="w-4 h-4" />
                                            </Link>
                                            <button
                                                @click="deleteArticle(article)"
                                                class="p-2 text-gray-400 hover:text-red-600 transition"
                                                title="Hapus"
                                            >
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </template>
                                        <template v-else>
                                            <span
                                                class="text-xs text-gray-300 italic"
                                                >No Access</span
                                            >
                                        </template>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="articles.data.length === 0">
                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-gray-500"
                                >
                                    Belum ada artikel.
                                    <Link
                                        :href="route('admin.articles.create')"
                                        class="text-primary-600 font-bold hover:underline"
                                        >Tulis artikel pertama →</Link
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                    >
                        <p class="text-sm text-gray-500">
                            Menampilkan
                            <span class="font-medium">{{
                                articles.from || 0
                            }}</span>
                            sampai
                            <span class="font-medium">{{
                                articles.to || 0
                            }}</span>
                            dari
                            <span class="font-medium">{{
                                articles.total
                            }}</span>
                            artikel
                            <span v-if="articles.last_page > 1"
                                >(Halaman {{ articles.current_page }} dari
                                {{ articles.last_page }})</span
                            >
                        </p>

                        <div
                            v-if="articles.last_page > 1"
                            class="flex flex-wrap gap-1"
                        >
                            <Link
                                v-for="link in articles.links"
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

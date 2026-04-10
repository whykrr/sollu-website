<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    pages: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="CMS | Kelola Halaman" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Kelola Halaman Front-End
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="mb-6 text-gray-600">
                            Pilih halaman yang teks atau kontennya ingin Anda
                            ubah.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div
                                v-for="page in pages"
                                :key="page.slug"
                                class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ page.name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-4">
                                    Edit teks hero, fitur, dan visual untuk
                                    halaman {{ page.slug }}.
                                </p>
                                <Link
                                    :href="route('admin.pages.edit', page.slug)"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Edit Halaman
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

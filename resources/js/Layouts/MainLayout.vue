<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { Menu, X, Rocket } from "lucide-vue-next";

const isMenuOpen = ref(false);
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
const siteSettings = computed(() => usePage().props.siteSettings || {});
</script>

<template>
    <div class="min-h-screen bg-white font-sans text-gray-900 flex flex-col">
        <!-- Header / Navbar -->
        <header
            class="fixed w-full bg-white/90 backdrop-blur-md z-50 border-b border-gray-100 transition-all"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <Link
                            href="/"
                            class="flex items-center gap-2 text-primary-800 hover:text-primary-900 transition font-heading font-bold text-2xl"
                        >
                            <img
                                src="/storage/img/logo-colored.png"
                                alt="Sollu POS"
                                class="h-12 w-auto"
                            />
                        </Link>
                    </div>

                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <Link
                            href="/"
                            class="text-base font-medium text-gray-600 hover:text-main transition"
                            >Beranda</Link
                        >
                        <Link
                            href="/services"
                            class="text-base font-medium text-gray-600 hover:text-main transition"
                            >Layanan</Link
                        >
                        <Link
                            href="/pricing"
                            class="text-base font-medium text-gray-600 hover:text-main transition"
                            >Harga</Link
                        >
                        <Link
                            href="/blog"
                            class="text-base font-medium text-gray-600 hover:text-main transition"
                            >Blog</Link
                        >
                        <Link
                            href="/contact"
                            class="text-base font-medium text-gray-600 hover:text-main transition"
                            >Hubungi Kami</Link
                        >
                    </nav>

                    <!-- CTA Buttons -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a
                            :href="siteSettings.portal_url"
                            target="blank"
                            class="text-primary-700 font-medium hover:text-primary-900 transition"
                            >Masuk</a
                        >
                        <a
                            :href="siteSettings.cta_trial_url"
                            target="blank"
                            class="bg-linear-to-r from-main to-secondary text-white px-5 py-2.5 rounded-full font-medium shadow-md shadow-primary-500/30 hover:shadow-lg hover:shadow-primary-500/40 transition-all transform hover:-translate-y-0.5"
                        >
                            Coba Sekarang
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button
                            @click="toggleMenu"
                            class="text-gray-600 hover:text-primary-600 transition"
                        >
                            <Menu v-if="!isMenuOpen" class="w-7 h-7" />
                            <X v-else class="w-7 h-7" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div
                v-show="isMenuOpen"
                class="md:hidden bg-white border-b border-gray-100 absolute w-full shadow-lg"
            >
                <div
                    class="px-4 pt-2 pb-6 space-y-1 sm:px-3 flex flex-col gap-3"
                >
                    <Link
                        href="/"
                        @click="isMenuOpen = false"
                        class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50 rounded-md"
                        >Beranda</Link
                    >
                    <Link
                        href="/services"
                        @click="isMenuOpen = false"
                        class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50 rounded-md"
                        >Layanan</Link
                    >
                    <Link
                        href="/pricing"
                        @click="isMenuOpen = false"
                        class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50 rounded-md"
                        >Harga</Link
                    >
                    <Link
                        href="/blog"
                        @click="isMenuOpen = false"
                        class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50 rounded-md"
                        >Blog</Link
                    >
                    <Link
                        href="/contact"
                        @click="isMenuOpen = false"
                        class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50 rounded-md"
                        >Hubungi Kami</Link
                    >
                    <div class="h-px bg-gray-100 my-2"></div>
                    <a
                        :href="siteSettings.portal_url"
                        class="block px-3 py-2 text-base font-medium text-main"
                        >Masuk Aplikasi</a
                    >
                    <a
                        :href="siteSettings.cta_trial_url"
                        class="block px-3 py-3 text-center text-base font-medium bg-main text-white rounded-md mt-2 shadow-sm"
                        >Coba Sekarang Gratis</a
                    >
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow pt-20">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="col-span-1 md:col-span-2">
                        <Link
                            href="/"
                            class="flex items-center gap-2 text-white font-heading font-bold text-2xl mb-4"
                        >
                            <img
                                src="/storage/img/logo-white.png"
                                alt="Sollu POS"
                                class="h-8 w-auto"
                            />
                        </Link>
                        <p
                            class="text-gray-400 text-sm leading-relaxed max-w-sm"
                        >
                            Platform Point of Sale terbaik untuk UMKM, Retail,
                            dan F&B dengan sistem yang dinamis dan laporan super
                            cepat.
                        </p>
                    </div>
                    <div>
                        <h4
                            class="font-heading font-semibold text-lg mb-4 text-white"
                        >
                            Perusahaan
                        </h4>
                        <ul class="space-y-3">
                            <li>
                                <Link
                                    href="/services"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Layanan Kami</Link
                                >
                            </li>
                            <li>
                                <Link
                                    href="/pricing"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Harga & Paket</Link
                                >
                            </li>
                            <li>
                                <Link
                                    href="/blog"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Blog & Edukasi</Link
                                >
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4
                            class="font-heading font-semibold text-lg mb-4 text-white"
                        >
                            Bantuan
                        </h4>
                        <ul class="space-y-3">
                            <li>
                                <Link
                                    href="/contact"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Pusat Bantuan</Link
                                >
                            </li>
                            <li>
                                <Link
                                    href="/contact"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Hubungi Sales</Link
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Syarat & Ketentuan</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4"
                >
                    <p class="text-gray-500 text-sm">
                        &copy; {{ new Date().getFullYear() }} Sollu POS. All
                        rights reserved.
                    </p>
                    <div class="flex gap-4">
                        <!-- Social placeholders -->
                        <div
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center"
                        ></div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center"
                        ></div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center"
                        ></div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

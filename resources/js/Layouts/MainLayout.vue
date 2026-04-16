<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { Menu, X, Rocket, Facebook, Instagram, Twitter } from "lucide-vue-next";

const isMenuOpen = ref(false);
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
const siteSettings = computed(() => usePage().props.siteSettings || {});
</script>

<template>
    <Head>
        <link rel="icon" type="image/png" href="/img/icon-trans.png" />
    </Head>
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
                                src="/img/logo-colored.png"
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
                            >Tips Usaha</Link
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
                                src="/img/logo-white.png"
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
                                <Link
                                    href="/faq"
                                    class="text-gray-400 hover:text-white transition text-sm"
                                    >Pertanyaan Umum</Link
                                >
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4"
                >
                    <p class="text-gray-500 text-sm">
                        &copy; {{ new Date().getFullYear() }} Sollu Indonesia.
                        Seluruh hak dilindungi undang-undang.
                    </p>
                    <div class="flex gap-4">
                        <!-- Social placeholders -->
                        <a
                            v-if="siteSettings.social_facebook"
                            :href="siteSettings.social_facebook"
                            target="_blank"
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center text-gray-400 hover:text-white"
                        >
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a
                            v-if="siteSettings.social_instagram"
                            :href="siteSettings.social_instagram"
                            target="_blank"
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center text-gray-400 hover:text-white"
                        >
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a
                            v-if="siteSettings.social_twitter"
                            :href="siteSettings.social_twitter"
                            target="_blank"
                            class="w-8 h-8 rounded-full bg-gray-800 hover:bg-primary-600 transition cursor-pointer flex justify-center items-center text-gray-400 hover:text-white"
                        >
                            <Twitter class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating WhatsApp Button -->
        <a
            v-if="siteSettings.wa_number"
            :href="`https://wa.me/${siteSettings.wa_number}`"
            target="_blank"
            class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-4 rounded-full shadow-[0_4px_14px_0_rgba(37,211,102,0.39)] hover:shadow-[0_6px_20px_rgba(37,211,102,0.23)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group"
            aria-label="Hubungi via WhatsApp"
        >
            <span class="absolute right-full mr-4 bg-white text-gray-800 px-4 py-2 rounded-lg shadow-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap hidden md:block">
                Hubungi Kami
            </span>
            <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                <path d="M11.99 2C6.47 2 2 6.48 2 12c0 1.76.46 3.42 1.27 4.88L2 22l5.34-1.25c1.4.74 2.99 1.16 4.65 1.16 5.52 0 10-4.48 10-10S17.51 2 11.99 2zm0 18.06c-1.48 0-2.9-.38-4.18-1.07l-.3-.18-3.08.72.73-2.96-.2-.31A8.067 8.067 0 0 1 3.93 12c0-4.46 3.63-8.08 8.06-8.08 4.44 0 8.06 3.63 8.06 8.08 0 4.45-3.62 8.06-8.06 8.06zm4.4-6.02c-.24-.12-1.43-.71-1.65-.79-.22-.08-.38-.12-.54.12-.16.24-.62.79-.76.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.31-.74-1.8-.2-.48-.4-.41-.54-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.48-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28z"/>
            </svg>
        </a>
    </div>
</template>

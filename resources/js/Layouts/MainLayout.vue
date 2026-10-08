<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted, onUnmounted } from "vue";
import { Menu, X, ArrowUpRight, Facebook, Instagram, Twitter } from "lucide-vue-next";

const isMenuOpen = ref(false);
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const isScrolled = ref(false);
const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const page = usePage();
const siteSettings = computed(() => page.props.siteSettings || {});

const navigateToAnchor = (event, anchor) => {
    isMenuOpen.value = false;
    const isHome = page.url === "/" || page.url.startsWith("/#");
    if (isHome) {
        event.preventDefault();
        const element = document.querySelector(anchor);
        if (element) {
            element.scrollIntoView({ behavior: "smooth" });
            window.history.pushState(null, "", anchor);
        }
    }
};
</script>

<template>
    <Head>
        <link rel="icon" type="image/png" href="/img/icon.png" />
    </Head>
    <div class="min-h-screen bg-white font-sans text-gray-900 flex flex-col selection:bg-blue-100 selection:text-blue-900">
        <!-- Header / Navbar -->
        <header
            :class="[
                'fixed w-full z-50 transition-all duration-300',
                isScrolled
                    ? 'bg-white/85 backdrop-blur-xl shadow-xs border-b border-gray-100'
                    : 'bg-white/70 backdrop-blur-md border-b border-gray-100/60',
            ]"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    :class="[
                        'flex justify-between items-center transition-all duration-300',
                        isScrolled ? 'h-16' : 'h-20',
                    ]"
                >
                    <!-- Brand Logo -->
                    <div class="shrink-0 flex items-center gap-2">
                        <Link
                            href="/"
                            class="flex items-center gap-2 hover:opacity-90 transition"
                        >
                            <img
                                src="/img/logo-colored.png"
                                alt="Sollu POS"
                                class="h-8 md:h-9 w-auto"
                            />
                        </Link>
                    </div>

                    <!-- Desktop Menu -->
                    <nav class="hidden lg:flex items-center space-x-7">
                        <a
                            href="/#fitur"
                            @click="navigateToAnchor($event, '#fitur')"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200"
                        >
                            Keunggulan
                        </a>
                        <a
                            href="/#solusi"
                            @click="navigateToAnchor($event, '#solusi')"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200"
                        >
                            Solusi Bisnis
                        </a>
                        <a
                            href="/#harga"
                            @click="navigateToAnchor($event, '#harga')"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200"
                        >
                            Paket & Harga
                        </a>
                        <a
                            href="/#testimoni"
                            @click="navigateToAnchor($event, '#testimoni')"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200"
                        >
                            Testimoni
                        </a>
                        <Link
                            href="/blog"
                            :class="[
                                'text-sm font-semibold transition duration-200',
                                $page.url.startsWith('/blog')
                                    ? 'text-primary-700 font-bold'
                                    : 'text-gray-600 hover:text-gray-950',
                            ]"
                        >
                            Tips Usaha
                        </Link>
                        <Link
                            href="/faq"
                            :class="[
                                'text-sm font-semibold transition duration-200',
                                $page.url.startsWith('/faq')
                                    ? 'text-primary-700 font-bold'
                                    : 'text-gray-600 hover:text-gray-950',
                            ]"
                        >
                            FAQ
                        </Link>
                        <a
                            href="/#kontak"
                            @click="navigateToAnchor($event, '#kontak')"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200"
                        >
                            Kontak
                        </a>
                    </nav>

                    <!-- CTA Buttons -->
                    <div class="hidden lg:flex items-center space-x-3">
                        <a
                            v-if="siteSettings.portal_url"
                            :href="siteSettings.portal_url"
                            target="_blank"
                            rel="noopener"
                            class="text-sm font-semibold text-gray-700 hover:text-gray-950 px-3 py-2 transition"
                        >
                            Masuk
                        </a>
                        <a
                            :href="siteSettings.cta_trial_url || '#kontak'"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center bg-main hover:bg-main-dark text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow"
                        >
                            Coba Gratis
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="lg:hidden flex items-center">
                        <button
                            @click="toggleMenu"
                            class="p-2 text-gray-700 hover:text-main rounded-lg hover:bg-gray-100 transition"
                            aria-label="Toggle navigation menu"
                        >
                            <Menu v-if="!isMenuOpen" class="w-6 h-6" />
                            <X v-else class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="transform -translate-y-2 opacity-0"
                enter-to-class="transform translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="transform translate-y-0 opacity-100"
                leave-to-class="transform -translate-y-2 opacity-0"
            >
                <div
                    v-show="isMenuOpen"
                    class="lg:hidden bg-white/98 backdrop-blur-xl border-b border-gray-200 absolute w-full shadow-xl"
                >
                    <div class="px-5 pt-3 pb-6 flex flex-col space-y-2">
                        <a
                            href="/#fitur"
                            @click="navigateToAnchor($event, '#fitur')"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Keunggulan
                        </a>
                        <a
                            href="/#solusi"
                            @click="navigateToAnchor($event, '#solusi')"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Solusi Bisnis
                        </a>
                        <a
                            href="/#harga"
                            @click="navigateToAnchor($event, '#harga')"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Paket & Harga
                        </a>
                        <a
                            href="/#testimoni"
                            @click="navigateToAnchor($event, '#testimoni')"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Testimoni
                        </a>
                        <Link
                            href="/blog"
                            @click="isMenuOpen = false"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Tips Usaha
                        </Link>
                        <Link
                            href="/faq"
                            @click="isMenuOpen = false"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Pertanyaan Umum (FAQ)
                        </Link>
                        <a
                            href="/#kontak"
                            @click="navigateToAnchor($event, '#kontak')"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Hubungi Kami
                        </a>
                        <div class="h-px bg-gray-100 my-2"></div>
                        <a
                            v-if="siteSettings.portal_url"
                            :href="siteSettings.portal_url"
                            target="_blank"
                            class="px-3 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg transition"
                        >
                            Masuk Aplikasi
                        </a>
                        <a
                            :href="siteSettings.cta_trial_url || '#kontak'"
                            target="_blank"
                            class="mt-2 block w-full text-center bg-main hover:bg-main-dark text-white font-semibold py-3 px-4 rounded-full transition shadow-sm"
                        >
                            Coba Sekarang Gratis
                        </a>
                    </div>
                </div>
            </Transition>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow pt-20">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-[#061a40] text-white pt-20 pb-12 border-t border-[#0d285c]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-12 mb-16">
                    <div class="col-span-1 md:col-span-2">
                        <Link href="/" class="inline-block mb-6">
                            <img
                                src="/img/logo-white.png"
                                alt="Sollu POS"
                                class="h-8 w-auto"
                            />
                        </Link>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-sm mb-6 font-sans">
                            Sistem kasir dan manajemen bisnis terpadu untuk pelaku usaha F&B, Retail, dan Jasa. Cepat, andal, dan siap membantu skala bisnis Anda bertumbuh.
                        </p>
                        <div class="flex items-center gap-3">
                            <a
                                v-if="siteSettings.social_facebook"
                                :href="siteSettings.social_facebook"
                                target="_blank"
                                rel="noopener"
                                class="w-9 h-9 rounded-full bg-[#0a2558] hover:bg-main transition flex items-center justify-center text-blue-200 hover:text-white"
                                aria-label="Facebook"
                            >
                                <Facebook class="w-4 h-4" />
                            </a>
                            <a
                                v-if="siteSettings.social_instagram"
                                :href="siteSettings.social_instagram"
                                target="_blank"
                                rel="noopener"
                                class="w-9 h-9 rounded-full bg-[#0a2558] hover:bg-main transition flex items-center justify-center text-blue-200 hover:text-white"
                                aria-label="Instagram"
                            >
                                <Instagram class="w-4 h-4" />
                            </a>
                            <a
                                v-if="siteSettings.social_twitter"
                                :href="siteSettings.social_twitter"
                                target="_blank"
                                rel="noopener"
                                class="w-9 h-9 rounded-full bg-[#0a2558] hover:bg-main transition flex items-center justify-center text-blue-200 hover:text-white"
                                aria-label="Twitter"
                            >
                                <Twitter class="w-4 h-4" />
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-blue-200 mb-5">
                            Solusi Bisnis
                        </h4>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="/#solusi" @click="navigateToAnchor($event, '#solusi')" class="text-blue-100/70 hover:text-white transition">Restoran & Kafe</a>
                            </li>
                            <li>
                                <a href="/#solusi" @click="navigateToAnchor($event, '#solusi')" class="text-blue-100/70 hover:text-white transition">Toko Retail & Butik</a>
                            </li>
                            <li>
                                <a href="/#solusi" @click="navigateToAnchor($event, '#solusi')" class="text-blue-100/70 hover:text-white transition">Salon & Usaha Jasa</a>
                            </li>
                            <li>
                                <a href="/#harga" @click="navigateToAnchor($event, '#harga')" class="text-blue-100/70 hover:text-white transition">Daftar Paket Harga</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-blue-200 mb-5">
                            Wawasan & Bantuan
                        </h4>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <Link href="/blog" class="text-blue-100/70 hover:text-white transition">Tips & Edukasi Bisnis</Link>
                            </li>
                            <li>
                                <Link href="/faq" class="text-blue-100/70 hover:text-white transition">Pertanyaan Umum (FAQ)</Link>
                            </li>
                            <li>
                                <a href="/#kontak" @click="navigateToAnchor($event, '#kontak')" class="text-blue-100/70 hover:text-white transition">Konsultasi Kebutuhan</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-blue-200 mb-5">
                            Kontak Resmi
                        </h4>
                        <ul class="space-y-3 text-sm text-blue-100/70">
                            <li v-if="siteSettings.contact_email">
                                <a :href="`mailto:${siteSettings.contact_email}`" class="hover:text-white transition">
                                    {{ siteSettings.contact_email }}
                                </a>
                            </li>
                            <li v-if="siteSettings.wa_number">
                                <a :href="`https://wa.me/${siteSettings.wa_number}`" target="_blank" class="hover:text-white transition flex items-center gap-1.5">
                                    WhatsApp Resmi <ArrowUpRight class="w-3.5 h-3.5" />
                                </a>
                            </li>
                            <li v-if="siteSettings.office_address" class="leading-relaxed text-xs text-blue-200/50 whitespace-pre-line">
                                {{ siteSettings.office_address }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-[#0d285c] pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-blue-200/60">
                    <p>
                        &copy; {{ new Date().getFullYear() }} PT. Solusi Dari Anak Bangsa. Seluruh hak dilindungi undang-undang.
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="/#fitur" class="hover:text-white transition">Fitur</a>
                        <a href="/#harga" class="hover:text-white transition">Harga</a>
                        <Link href="/faq" class="hover:text-white transition">FAQ</Link>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating WhatsApp Action -->
        <a
            v-if="siteSettings.wa_number"
            :href="`https://wa.me/${siteSettings.wa_number}`"
            target="_blank"
            rel="noopener"
            class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-3.5 rounded-full shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 flex items-center justify-center group"
            aria-label="Konsultasi via WhatsApp"
        >
            <span
                class="absolute right-full mr-3 bg-[#061a40] text-white text-xs font-medium px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap shadow-md hidden md:block"
            >
                Konsultasi WhatsApp
            </span>
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path
                    d="M11.99 2C6.47 2 2 6.48 2 12c0 1.76.46 3.42 1.27 4.88L2 22l5.34-1.25c1.4.74 2.99 1.16 4.65 1.16 5.52 0 10-4.48 10-10S17.51 2 11.99 2zm0 18.06c-1.48 0-2.9-.38-4.18-1.07l-.3-.18-3.08.72.73-2.96-.2-.31A8.067 8.067 0 0 1 3.93 12c0-4.46 3.63-8.08 8.06-8.08 4.44 0 8.06 3.63 8.06 8.08 0 4.45-3.62 8.06-8.06 8.06zm4.4-6.02c-.24-.12-1.43-.71-1.65-.79-.22-.08-.38-.12-.54.12-.16.24-.62.79-.76.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.31-.74-1.8-.2-.48-.4-.41-.54-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.48-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28z"
                />
            </svg>
        </a>
    </div>
</template>

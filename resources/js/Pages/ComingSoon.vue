<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";

// ==============================
// Countdown Timer
// ==============================
const props = defineProps({
    launchDate: {
        type: String,
        default: null,
    },
});

const days = ref("00");
const hours = ref("00");
const minutes = ref("00");
const seconds = ref("00");

let countdownInterval = null;

//set launch date on 1 may 2026

const getTargetDate = () => {
    if (props.launchDate) return new Date(props.launchDate);
    return new Date(2026, 4, 1); // May 1, 2026 (month is 0-indexed)
};

const updateCountdown = () => {
    const now = new Date();
    const diff = getTargetDate() - now;

    if (diff <= 0) {
        days.value = "00";
        hours.value = "00";
        minutes.value = "00";
        seconds.value = "00";
        return;
    }

    days.value = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(
        2,
        "0",
    );
    hours.value = String(
        Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
    ).padStart(2, "0");
    minutes.value = String(
        Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)),
    ).padStart(2, "0");
    seconds.value = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(
        2,
        "0",
    );
};

// ==============================
// Subscribe (using Inertia useForm)
// ==============================
const form = useForm({
    email: "",
});

const message = ref("");
const messageType = ref(""); // 'success' | 'error'

const handleSubscribe = () => {
    if (!form.email.trim() || form.processing) return;

    message.value = "";
    messageType.value = "";

    form.post(route("coming-soon.subscribe"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            message.value =
                page.props.flash?.success ||
                "Terima kasih! Anda akan menjadi yang pertama tahu saat kami meluncurkan.";
            messageType.value = "success";
            form.reset("email");
        },
        onError: (errors) => {
            if (errors.email) {
                message.value = errors.email;
            } else {
                message.value = "Terjadi kesalahan. Silakan coba lagi nanti.";
            }
            messageType.value = "error";
        },
    });
};

onMounted(() => {
    updateCountdown();
    countdownInterval = setInterval(updateCountdown, 1000);
});

onUnmounted(() => {
    if (countdownInterval) clearInterval(countdownInterval);
});
</script>

<template>
    <Head title="Segera Hadir">
        <meta
            name="description"
            content="Sesuatu yang menarik sedang kami siapkan. Sollu POS — Platform Kasir Digital terbaik untuk UMKM Indonesia."
        />
        <meta property="og:title" content="Segera Hadir — Sollu Indonesia" />
        <meta
            property="og:description"
            content="Sesuatu yang menarik sedang kami siapkan. Sollu POS — Platform Kasir Digital terbaik untuk UMKM Indonesia."
        />
        <meta property="og:type" content="website" />
        <link rel="icon" type="image/png" href="/img/icon-trans.png" />
    </Head>

    <!-- Full-screen wrapper -->
    <div
        class="relative min-h-screen flex items-center justify-center overflow-hidden font-sans"
    >
        <!-- Background gradient -->
        <div
            class="fixed inset-0 bg-gradient-to-br from-[#172554] via-[#1e3a8a] to-[#1e40af] z-0"
        ></div>

        <!-- Floating orbs -->
        <div
            class="absolute w-[300px] h-[300px] md:w-[400px] md:h-[400px] rounded-full bg-[#06b6d4] blur-[80px] opacity-30 -top-[10%] -right-[5%] animate-float"
        ></div>
        <div
            class="absolute w-[200px] h-[200px] md:w-[300px] md:h-[300px] rounded-full bg-[#3b82f6] blur-[80px] opacity-30 -bottom-[10%] -left-[5%] animate-float-delayed"
        ></div>
        <div
            class="absolute w-[150px] h-[150px] md:w-[200px] md:h-[200px] rounded-full bg-[#67e8f9] blur-[80px] opacity-15 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-float-slow"
        ></div>

        <!-- Grid pattern overlay -->
        <div class="fixed inset-0 grid-pattern z-[1]"></div>

        <!-- Content -->
        <div
            class="relative z-10 text-center w-full max-w-[640px] px-4 sm:px-6 py-8 md:py-12"
        >
            <!-- Logo -->
            <img
                src="/img/logo-white.png"
                alt="Sollu POS"
                class="h-8 sm:h-10 md:h-12 mx-auto mb-6 md:mb-10 animate-fade-in"
            />

            <!-- Glass card -->
            <div
                class="glass-card rounded-2xl md:rounded-3xl p-5 sm:p-8 md:p-10 flex flex-col items-center animate-fade-in-delay-1"
            >
                <!-- Rocket icon -->
                <div
                    class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-2xl md:rounded-3xl bg-white/[0.08] backdrop-blur-xl border border-white/[0.12] flex items-center justify-center mb-4 md:mb-6"
                >
                    <svg
                        class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-[#67e8f9] animate-rocket"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z"
                        />
                        <path
                            d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2Z"
                        />
                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" />
                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5" />
                    </svg>
                </div>

                <!-- Status badge -->
                <div
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full bg-[#06b6d4]/15 border border-[#06b6d4]/30 text-[#67e8f9] text-[0.7rem] sm:text-xs font-semibold tracking-wider uppercase mb-4 md:mb-5"
                >
                    <span class="text-sm sm:text-base animate-sparkle">✨</span>
                    Segera Hadir
                </div>

                <!-- Title -->
                <h1
                    class="font-heading text-2xl sm:text-3xl md:text-4xl lg:text-[2.5rem] font-bold leading-tight mb-3 md:mb-4 bg-gradient-to-br from-white to-[#67e8f9] bg-clip-text text-transparent"
                >
                    Sesuatu yang Menarik Sedang Disiapkan
                </h1>

                <!-- Description -->
                <p
                    class="text-sm sm:text-base md:text-lg text-white/60 leading-relaxed mb-6 md:mb-8 max-w-md mx-auto"
                >
                    Kami sedang menyiapkan sesuatu yang luar biasa untuk bisnis
                    Anda. Pantau terus dan jadilah yang pertama tahu saat kami
                    meluncurkan!
                </p>

                <!-- Countdown Timer -->
                <div
                    class="flex items-start justify-center gap-2 sm:gap-3 md:gap-4 mb-6 md:mb-8"
                >
                    <!-- Days -->
                    <div class="flex flex-col items-center gap-1.5">
                        <div
                            class="countdown-box w-14 sm:w-16 md:w-[72px] py-2.5 sm:py-3 md:py-4 rounded-xl md:rounded-2xl bg-white/[0.08] backdrop-blur-sm border border-white/10 text-xl sm:text-2xl md:text-[2.2rem] font-heading font-bold text-white text-center transition-all hover:-translate-y-0.5 hover:bg-white/[0.12]"
                        >
                            {{ days }}
                        </div>
                        <span
                            class="text-[0.6rem] sm:text-[0.65rem] md:text-[0.7rem] text-white/40 uppercase tracking-widest font-semibold"
                            >Hari</span
                        >
                    </div>

                    <span
                        class="text-lg sm:text-xl md:text-2xl font-bold text-white/20 pt-2.5 sm:pt-3 md:pt-4 animate-blink"
                        >:</span
                    >

                    <!-- Hours -->
                    <div class="flex flex-col items-center gap-1.5">
                        <div
                            class="countdown-box w-14 sm:w-16 md:w-[72px] py-2.5 sm:py-3 md:py-4 rounded-xl md:rounded-2xl bg-white/[0.08] backdrop-blur-sm border border-white/10 text-xl sm:text-2xl md:text-[2.2rem] font-heading font-bold text-white text-center transition-all hover:-translate-y-0.5 hover:bg-white/[0.12]"
                        >
                            {{ hours }}
                        </div>
                        <span
                            class="text-[0.6rem] sm:text-[0.65rem] md:text-[0.7rem] text-white/40 uppercase tracking-widest font-semibold"
                            >Jam</span
                        >
                    </div>

                    <span
                        class="text-lg sm:text-xl md:text-2xl font-bold text-white/20 pt-2.5 sm:pt-3 md:pt-4 animate-blink"
                        >:</span
                    >

                    <!-- Minutes -->
                    <div class="flex flex-col items-center gap-1.5">
                        <div
                            class="countdown-box w-14 sm:w-16 md:w-[72px] py-2.5 sm:py-3 md:py-4 rounded-xl md:rounded-2xl bg-white/[0.08] backdrop-blur-sm border border-white/10 text-xl sm:text-2xl md:text-[2.2rem] font-heading font-bold text-white text-center transition-all hover:-translate-y-0.5 hover:bg-white/[0.12]"
                        >
                            {{ minutes }}
                        </div>
                        <span
                            class="text-[0.6rem] sm:text-[0.65rem] md:text-[0.7rem] text-white/40 uppercase tracking-widest font-semibold"
                            >Menit</span
                        >
                    </div>

                    <span
                        class="text-lg sm:text-xl md:text-2xl font-bold text-white/20 pt-2.5 sm:pt-3 md:pt-4 animate-blink"
                        >:</span
                    >

                    <!-- Seconds -->
                    <div class="flex flex-col items-center gap-1.5">
                        <div
                            class="countdown-box w-14 sm:w-16 md:w-[72px] py-2.5 sm:py-3 md:py-4 rounded-xl md:rounded-2xl bg-white/[0.08] backdrop-blur-sm border border-white/10 text-xl sm:text-2xl md:text-[2.2rem] font-heading font-bold text-white text-center transition-all hover:-translate-y-0.5 hover:bg-white/[0.12]"
                        >
                            {{ seconds }}
                        </div>
                        <span
                            class="text-[0.6rem] sm:text-[0.65rem] md:text-[0.7rem] text-white/40 uppercase tracking-widest font-semibold"
                            >Detik</span
                        >
                    </div>
                </div>

                <!-- Email Subscribe Form -->
                <div class="w-full max-w-sm sm:max-w-md mx-auto">
                    <form
                        @submit.prevent="handleSubscribe"
                        class="flex flex-col sm:flex-row overflow-hidden rounded-2xl sm:rounded-full bg-white/[0.06] border border-white/10 transition-all focus-within:border-[#06b6d4]/50"
                    >
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Masukkan email Anda..."
                            required
                            :disabled="form.processing"
                            class="flex-1 px-4 sm:px-5 py-3.5 bg-transparent border-none text-white text-sm sm:text-[0.95rem] placeholder-white/35 outline-none text-center sm:text-left"
                        />
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-5 sm:px-7 py-3.5 bg-gradient-to-r from-[#3b82f6] to-[#06b6d4] text-white text-sm font-semibold border-none cursor-pointer whitespace-nowrap transition-all hover:opacity-90 disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            {{
                                form.processing
                                    ? "Mengirim..."
                                    : messageType === "success"
                                      ? "Terdaftar! ✅"
                                      : "Beritahu Saya"
                            }}
                        </button>
                    </form>

                    <p class="text-[0.75rem] sm:text-xs text-white/30 mt-3">
                        Kami tidak akan mengirim spam. Hanya notifikasi
                        peluncuran.
                    </p>

                    <!-- Status message -->
                    <Transition name="fade">
                        <div
                            v-if="message"
                            :class="[
                                'mt-3 px-4 py-2.5 rounded-xl text-[0.8rem] sm:text-sm font-medium text-center',
                                messageType === 'success'
                                    ? 'bg-emerald-500/15 border border-emerald-500/30 text-emerald-300'
                                    : 'bg-red-500/15 border border-red-500/30 text-red-300',
                            ]"
                        >
                            {{ message }}
                        </div>
                    </Transition>
                </div>
            </div>

            <!-- Social Links -->
            <div
                class="flex justify-center gap-3 mt-5 md:mt-6 animate-fade-in-delay-2"
            >
                <a
                    href="#"
                    class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-white/[0.06] border border-white/[0.08] flex items-center justify-center text-white/50 transition-all hover:bg-white/[0.12] hover:text-white hover:-translate-y-0.5"
                    aria-label="Instagram"
                >
                    <svg
                        class="w-4.5 h-4.5 md:w-5 md:h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect
                            x="2"
                            y="2"
                            width="20"
                            height="20"
                            rx="5"
                            ry="5"
                        />
                        <circle cx="12" cy="12" r="4" />
                        <circle
                            cx="17.5"
                            cy="6.5"
                            r="1"
                            fill="currentColor"
                            stroke="none"
                        />
                    </svg>
                </a>
                <a
                    href="#"
                    class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-white/[0.06] border border-white/[0.08] flex items-center justify-center text-white/50 transition-all hover:bg-white/[0.12] hover:text-white hover:-translate-y-0.5"
                    aria-label="Twitter"
                >
                    <svg
                        class="w-4.5 h-4.5 md:w-5 md:h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"
                        />
                    </svg>
                </a>
                <a
                    href="#"
                    class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-white/[0.06] border border-white/[0.08] flex items-center justify-center text-white/50 transition-all hover:bg-white/[0.12] hover:text-white hover:-translate-y-0.5"
                    aria-label="WhatsApp"
                >
                    <svg
                        class="w-4.5 h-4.5 md:w-5 md:h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"
                        />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped>
.grid-pattern {
    background-image:
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 60px 60px;
}

.glass-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.08);
}

/* Animations */
@keyframes float {
    0%,
    100% {
        transform: translateY(0) scale(1);
    }
    50% {
        transform: translateY(-30px) scale(1.05);
    }
}
@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0) scale(1);
    }
    50% {
        transform: translateY(-20px) scale(1.03);
    }
}
@keyframes float-slow {
    0%,
    100% {
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        transform: translate(-50%, calc(-50% - 15px)) scale(1.05);
    }
}
@keyframes rocket-bounce {
    0%,
    100% {
        transform: translateY(0) rotate(-5deg);
    }
    50% {
        transform: translateY(-8px) rotate(5deg);
    }
}
@keyframes sparkle {
    0%,
    100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.3);
        opacity: 0.7;
    }
}
@keyframes blink {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}
.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite -3s;
}
.animate-float-slow {
    animation: float-slow 8s ease-in-out infinite -5s;
}
.animate-rocket {
    animation: rocket-bounce 3s ease-in-out infinite;
}
.animate-sparkle {
    animation: sparkle 2s ease-in-out infinite;
}
.animate-blink {
    animation: blink 1.5s ease-in-out infinite;
}
.animate-fade-in {
    animation: fadeInUp 0.8s ease forwards;
}
.animate-fade-in-delay-1 {
    animation: fadeInUp 0.8s ease 0.15s both;
}
.animate-fade-in-delay-2 {
    animation: fadeInUp 0.8s ease 0.3s both;
}

/* Vue transition */
.fade-enter-active {
    animation: fadeInUp 0.4s ease;
}
.fade-leave-active {
    animation: fadeInUp 0.3s ease reverse;
}
</style>

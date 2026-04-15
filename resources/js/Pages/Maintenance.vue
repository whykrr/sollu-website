<script setup>
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    contactEmail: {
        type: String,
        default: "hello@solluapp.com",
    },
});
</script>

<template>
    <Head title="Sedang Dalam Pemeliharaan">
        <meta name="robots" content="noindex, nofollow" />
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
            class="relative z-10 text-center w-full max-w-[560px] px-4 sm:px-6 py-8 md:py-12"
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
                <!-- Gear icon -->
                <div
                    class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-2xl md:rounded-3xl bg-white/[0.08] backdrop-blur-xl border border-white/[0.12] flex items-center justify-center mb-4 md:mb-6"
                >
                    <svg
                        class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-[#67e8f9] animate-spin-slow"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"
                        />
                    </svg>
                </div>

                <!-- Status badge -->
                <div
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full bg-[#06b6d4]/15 border border-[#06b6d4]/30 text-[#67e8f9] text-[0.7rem] sm:text-xs font-semibold tracking-wider uppercase mb-4 md:mb-5"
                >
                    <span
                        class="w-2 h-2 rounded-full bg-[#06b6d4] animate-pulse"
                    ></span>
                    Sedang Dalam Pemeliharaan
                </div>

                <!-- Title -->
                <h1
                    class="font-heading text-2xl sm:text-3xl md:text-4xl font-bold leading-tight mb-3 md:mb-4 bg-gradient-to-br from-white to-[#67e8f9] bg-clip-text text-transparent"
                >
                    Kami Sedang Meningkatkan Layanan
                </h1>

                <!-- Description -->
                <p
                    class="text-sm sm:text-base md:text-lg text-white/60 leading-relaxed mb-6 md:mb-8 max-w-md mx-auto"
                >
                    Website sedang dalam proses pemeliharaan berkala untuk
                    memberikan pengalaman yang lebih baik. Kami akan segera
                    kembali!
                </p>

                <!-- Animated progress bar -->
                <div class="w-full max-w-xs sm:max-w-sm mx-auto mb-6 md:mb-8">
                    <div
                        class="w-full h-1 bg-white/10 rounded-full overflow-hidden"
                    >
                        <div
                            class="h-full rounded-full bg-gradient-to-r from-[#3b82f6] to-[#06b6d4] animate-progress"
                        ></div>
                    </div>
                    <p class="text-[0.75rem] sm:text-xs text-white/40 mt-2.5">
                        Proses pemeliharaan sedang berjalan...
                    </p>
                </div>

                <!-- Contact info -->
                <div>
                    <p class="text-xs sm:text-sm text-white/40">
                        Ada pertanyaan mendesak? Hubungi kami di
                        <a
                            :href="`mailto:${contactEmail}`"
                            class="text-[#67e8f9] font-medium hover:text-white transition-colors"
                        >
                            {{ contactEmail }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.grid-pattern {
    background-image: linear-gradient(
            rgba(255, 255, 255, 0.03) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(255, 255, 255, 0.03) 1px,
            transparent 1px
        );
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
@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
@keyframes progress-anim {
    0% {
        width: 20%;
        opacity: 0.7;
    }
    50% {
        width: 80%;
        opacity: 1;
    }
    100% {
        width: 20%;
        opacity: 0.7;
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
.animate-spin-slow {
    animation: spin-slow 6s linear infinite;
}
.animate-progress {
    animation: progress-anim 3s ease-in-out infinite;
}
.animate-fade-in {
    animation: fadeInUp 0.8s ease forwards;
}
.animate-fade-in-delay-1 {
    animation: fadeInUp 0.8s ease 0.15s both;
}
</style>

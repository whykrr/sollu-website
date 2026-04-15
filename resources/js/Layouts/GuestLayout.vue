<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <link rel="icon" type="image/png" href="/img/icon-dark.png" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <img
                    src="/img/logo-colored.png"
                    alt="Sollu POS"
                    class="h-12 w-auto"
                />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

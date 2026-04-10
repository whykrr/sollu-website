<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    FileText,
    Layers,
    Users,
    Mail,
    TrendingUp,
    Eye,
    UserCheck,
    Globe,
} from "lucide-vue-next";

// Chart.js Registration
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    Filler,
} from "chart.js";
import { Line, Doughnut } from "vue-chartjs";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    Filler,
);

const props = defineProps({
    stats: Object,
    chartData: Object,
    popularPages: Array,
});

// Brand colors
const primaryColor = "#0284c7";
const primaryColorLight = "rgba(2, 132, 199, 0.15)";
const secondaryColor = "#06b6d4";
const secondaryColorLight = "rgba(6, 182, 212, 0.15)";

// Formatting helpers
const formatNumber = (num) => new Intl.NumberFormat("id-ID").format(num);

const formatPageName = (url) => {
    if (url === "/" || url === "") return "Beranda";
    const names = {
        services: "Layanan",
        pricing: "Harga",
        contact: "Kontak",
        blog: "Blog",
    };
    const parts = url.replace(/^\//, "").split("/");
    return names[parts[0]] || "/" + url;
};

// 1. Line Chart Data (Real Traffic from visitors table)
const trafficChartData = {
    labels: props.chartData.traffic.labels,
    datasets: [
        {
            label: "Total Kunjungan",
            backgroundColor: primaryColorLight,
            borderColor: primaryColor,
            borderWidth: 2,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: primaryColor,
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4,
            data: props.chartData.traffic.pageViews,
        },
        {
            label: "Pengunjung Unik",
            backgroundColor: secondaryColorLight,
            borderColor: secondaryColor,
            borderWidth: 2,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: secondaryColor,
            pointBorderWidth: 2,
            pointRadius: 3,
            pointHoverRadius: 5,
            fill: true,
            tension: 0.4,
            borderDash: [5, 5],
            data: props.chartData.traffic.unique,
        },
    ],
};

const trafficChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: "top",
            align: "end",
            labels: {
                usePointStyle: true,
                boxWidth: 8,
                color: "#6b7280",
                font: { size: 12 },
            },
        },
        tooltip: {
            mode: "index",
            intersect: false,
            backgroundColor: "rgba(255, 255, 255, 0.95)",
            titleColor: "#1f2937",
            bodyColor: "#4b5563",
            borderColor: "#e5e7eb",
            borderWidth: 1,
            padding: 12,
            displayColors: true,
            boxWidth: 8,
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: "#f3f4f6", drawBorder: false },
            ticks: { color: "#9ca3af", font: { size: 11 }, stepSize: 1 },
        },
        x: {
            grid: { display: false, drawBorder: false },
            ticks: { color: "#9ca3af", font: { size: 11 } },
        },
    },
    interaction: { mode: "nearest", axis: "x", intersect: false },
};

// 2. Article Growth Chart
const articleChartData = {
    labels: props.chartData.articles.labels,
    datasets: [
        {
            label: "Artikel Dibuat",
            backgroundColor: "rgba(245, 158, 11, 0.15)",
            borderColor: "#f59e0b",
            borderWidth: 2,
            pointRadius: 4,
            fill: true,
            tension: 0.4,
            data: props.chartData.articles.data,
        },
    ],
};

const articleChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        y: {
            beginAtZero: true,
            ticks: { stepSize: 1 },
            grid: { color: "#f3f4f6" },
        },
        x: { grid: { display: false } },
    },
};

// 3. Doughnut Chart (Category Proportion)
const categoryColors = [
    "#0284c7",
    "#38bdf8",
    "#06b6d4",
    "#0f172a",
    "#94a3b8",
    "#f59e0b",
];
const categoryChartData = {
    labels: props.chartData.categories.labels,
    datasets: [
        {
            backgroundColor: categoryColors,
            borderWidth: 0,
            data: props.chartData.categories.data,
        },
    ],
};

const categoryChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: "right",
            labels: {
                usePointStyle: true,
                boxWidth: 8,
                color: "#4b5563",
                font: { size: 12 },
            },
        },
    },
    cutout: "70%",
};

// Stat Cards config
const statCards = [
    {
        title: "Kunjungan Hari Ini",
        value: props.stats.visitors_today,
        icon: Eye,
        color: "text-sky-600",
        bg: "bg-sky-50",
    },
    {
        title: "Pengunjung Unik",
        value: props.stats.unique_today,
        icon: UserCheck,
        color: "text-teal-600",
        bg: "bg-teal-50",
    },
    {
        title: "Total Artikel",
        value: props.stats.articles,
        icon: FileText,
        color: "text-blue-600",
        bg: "bg-blue-50",
    },
    {
        title: "Kategori",
        value: props.stats.categories,
        icon: Layers,
        color: "text-indigo-600",
        bg: "bg-indigo-50",
    },
    {
        title: "Pesan Masuk",
        value: props.stats.messages,
        icon: Mail,
        color: "text-emerald-600",
        bg: "bg-emerald-50",
    },
    {
        title: "Pengguna",
        value: props.stats.users,
        icon: Users,
        color: "text-orange-600",
        bg: "bg-orange-50",
    },
];

// Calculate total page views in the last 14 days
const totalPageViews = props.chartData.traffic.pageViews.reduce(
    (a, b) => a + b,
    0,
);
</script>

<template>
    <Head title="CMS | Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Ringkasan Eksekutif
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Stat Cards -->
                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6"
                >
                    <div
                        v-for="(card, i) in statCards"
                        :key="i"
                        class="overflow-hidden bg-white shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow"
                    >
                        <div class="p-5 flex items-center justify-between">
                            <div>
                                <p
                                    class="text-xs font-medium text-gray-500 uppercase tracking-wide"
                                >
                                    {{ card.title }}
                                </p>
                                <p
                                    class="mt-1 text-2xl font-bold text-gray-900"
                                >
                                    {{ formatNumber(card.value) }}
                                </p>
                            </div>
                            <div :class="['p-3 rounded-xl', card.bg]">
                                <component
                                    :is="card.icon"
                                    :class="['w-5 h-5', card.color]"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Traffic Chart -->
                <div
                    class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden"
                >
                    <div
                        class="px-6 py-5 border-b border-gray-100 flex items-center justify-between"
                    >
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Trafik Pengunjung
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Data kunjungan riil website dalam 14 hari
                                terakhir.
                            </p>
                        </div>
                        <div
                            class="flex items-center gap-2 text-sm font-medium text-sky-700 bg-sky-50 px-3 py-1.5 rounded-full"
                        >
                            <Globe class="w-4 h-4" />
                            <span
                                >{{ formatNumber(totalPageViews) }} views</span
                            >
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-80 w-full relative">
                            <Line
                                :data="trafficChartData"
                                :options="trafficChartOptions"
                            />
                        </div>
                    </div>
                </div>

                <!-- Secondary Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Article Growth Chart -->
                    <div
                        class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6"
                    >
                        <h3 class="text-base font-bold text-gray-900 mb-1">
                            Pertumbuhan Artikel
                        </h3>
                        <p class="text-xs text-gray-500 mb-6">
                            Tren penambahan artikel 6 bulan terakhir.
                        </p>
                        <div class="h-56 w-full relative">
                            <Line
                                :data="articleChartData"
                                :options="articleChartOptions"
                            />
                        </div>
                    </div>

                    <!-- Category Proportion Chart -->
                    <div
                        class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6"
                    >
                        <h3 class="text-base font-bold text-gray-900 mb-1">
                            Distribusi Konten
                        </h3>
                        <p class="text-xs text-gray-500 mb-6">
                            Proporsi artikel per kategori.
                        </p>
                        <div
                            class="h-56 w-full relative flex items-center justify-center"
                        >
                            <div
                                v-if="
                                    props.chartData.categories.data.length === 0
                                "
                                class="text-center text-gray-400"
                            >
                                Belum ada artikel.
                            </div>
                            <Doughnut
                                v-else
                                :data="categoryChartData"
                                :options="categoryChartOptions"
                            />
                        </div>
                    </div>

                    <!-- Popular Pages -->
                    <div
                        class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6"
                    >
                        <h3 class="text-base font-bold text-gray-900 mb-1">
                            Halaman Populer
                        </h3>
                        <p class="text-xs text-gray-500 mb-6">
                            Halaman paling banyak dikunjungi (7 hari).
                        </p>
                        <div
                            v-if="popularPages.length === 0"
                            class="text-center text-gray-400 py-8"
                        >
                            Belum ada data kunjungan.
                        </div>
                        <ul v-else class="space-y-3">
                            <li
                                v-for="(page, i) in popularPages"
                                :key="i"
                                class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex items-center justify-center w-7 h-7 rounded-full bg-primary-50 text-primary-700 text-xs font-bold"
                                        >{{ i + 1 }}</span
                                    >
                                    <span
                                        class="text-sm text-gray-700 font-medium"
                                        >{{ formatPageName(page.url) }}</span
                                    >
                                </div>
                                <span
                                    class="text-sm font-semibold text-gray-900"
                                    >{{ formatNumber(page.views) }}
                                    <span
                                        class="text-xs text-gray-400 font-normal"
                                        >views</span
                                    ></span
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

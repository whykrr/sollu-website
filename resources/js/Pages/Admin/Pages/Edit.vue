<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    ChevronDown,
    ExternalLink,
    Upload,
    Plus,
    Trash2,
    RotateCcw,
    Layers,
    Check
} from "lucide-vue-next";
import axios from "axios";

const props = defineProps({
    slug: String,
    name: String,
    pageContents: Array,
});

const form = useForm({
    contents: JSON.parse(JSON.stringify(props.pageContents)), // Deep copy
});

// Section Indonesian Metadata
const sectionMeta = {
    hero: {
        title: "1. Banner Utama (Hero Section)",
        desc: "Headline utama, subjudul pengantar, teks tombol CTA, dan badge atas.",
        badge: "Hero",
    },
    differentiators: {
        title: "2. Keunggulan & Metrik Utama (Differentiators & Stats)",
        desc: "Angka statistik pencapaian mitra dan 6 poin keunggulan sistem Sollu POS.",
        badge: "Keunggulan",
    },
    showcase: {
        title: "3. Fitur Unggulan — Mockup Komputer & Tablet",
        desc: "Teks pengantar dan pengaturan gambar frame komputer monitor & tablet kasir.",
        badge: "Device Mockup",
    },
    solutions: {
        title: "4. Solusi Industri (F&B, Retail, Jasa)",
        desc: "Tab navigasi per kategori bisnis, daftar fitur unggulan, dan foto operasional.",
        badge: "Solusi Bisnis",
    },
    pricing_plans: {
        title: "5. Paket & Harga (Pricing Tiers)",
        desc: "Daftar paket (Basic, Profesional, Enterprise), harga, fitur, dan kartu terpopuler.",
        badge: "Harga",
    },
    testimonials: {
        title: "6. Cerita & Ulasan Pelanggan (Testimonials)",
        desc: "Kutipan ulasan mitra bisnis, nama pemilik, jenis usaha, dan foto profil avatar.",
        badge: "Testimoni",
    },
    contact_cta: {
        title: "7. Kontak & Konsultasi (Contact Section)",
        desc: "Headline dan kalimat ajakan pada formulir konsultasi dan tombol WhatsApp.",
        badge: "Kontak",
    },
};

// Accordion open/collapse states
const openSections = ref({});
props.pageContents.forEach((sec, idx) => {
    // Open hero by default or all if fewer than 3
    openSections.value[sec.section_key] = idx === 0 || props.pageContents.length <= 2;
});

const toggleSection = (key) => {
    openSections.value[key] = !openSections.value[key];
};

const expandAll = () => {
    props.pageContents.forEach((sec) => {
        openSections.value[sec.section_key] = true;
    });
};

const collapseAll = () => {
    props.pageContents.forEach((sec) => {
        openSections.value[sec.section_key] = false;
    });
};

const submit = () => {
    form.put(route("admin.pages.update", props.slug), {
        preserveScroll: true,
    });
};

const uploadImage = async (event, section, attrKey) => {
    const file = event.target.files[0];
    if (!file) return;

    const btn = event.target.previousElementSibling;
    const oldText = btn.innerText;
    btn.innerText = "Mengunggah...";

    const formData = new FormData();
    formData.append("image", file);

    try {
        const response = await axios.post(route("admin.upload"), formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        section.attributes[attrKey] = response.data.url;
    } catch (error) {
        alert("Gagal mengupload gambar. Pastikan format jpeg, png, jpg, gif, svg, atau webp.");
    } finally {
        btn.innerText = oldText;
        event.target.value = "";
    }
};

const formatKeyName = (key) => {
    return key.replace(/_/g, " ").replace(/\b\w/g, (l) => l.toUpperCase());
};

const removeArrayItem = (section, attrKey, index) => {
    if (confirm(`Hapus item ke-${index + 1}?`)) {
        section.attributes[attrKey].splice(index, 1);
    }
};

const addArrayItem = (section, attrKey) => {
    const currentArr = section.attributes[attrKey];
    if (currentArr && currentArr.length > 0) {
        const template = JSON.parse(JSON.stringify(currentArr[0]));
        Object.keys(template).forEach((k) => {
            if (Array.isArray(template[k])) template[k] = [""];
            else if (typeof template[k] === "boolean") template[k] = false;
            else template[k] = "";
        });
        currentArr.push(template);
    } else if (attrKey === "stats") {
        section.attributes[attrKey].push({ value: "100+", label: "Mitra Baru" });
    } else if (attrKey === "items") {
        section.attributes[attrKey].push({ title: "Fitur Baru", description: "Deskripsi fitur baru." });
    } else {
        section.attributes[attrKey].push({ title: "", description: "" });
    }
};

const resetShowcaseToDefault = (section) => {
    section.attributes.image_url = "/img/showcase-devices.svg";
};
</script>

<template>
    <Head :title="`CMS | Edit Halaman ${name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-xl font-bold leading-tight text-gray-900">
                            Edit Halaman: {{ name }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-primary-700">
                            {{ slug === 'home' ? 'Landing Page' : slug }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Sesuaikan seluruh teks, penawaran, dan aset visual yang tampil kepada pengunjung.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        :href="slug === 'home' ? '/' : `/${slug}`"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50 transition"
                    >
                        <span>Lihat Website</span>
                        <ExternalLink class="w-3.5 h-3.5" />
                    </a>

                    <button
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-5 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-xs disabled:opacity-50"
                    >
                        {{ form.processing ? "Menyimpan..." : "Simpan Perubahan" }}
                    </button>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Success Notification Flash -->
                <div
                    v-if="$page.props.flash?.success"
                    class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-center justify-between"
                >
                    <div class="flex items-center gap-2">
                        <Check class="w-4 h-4 text-green-600 shrink-0" />
                        <span>{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                <!-- Global Accordion Controls -->
                <div class="flex items-center justify-between px-1">
                    <div class="text-xs text-gray-500 font-medium">
                        Total {{ form.contents.length }} Bagian Konten
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="expandAll"
                            class="text-xs text-gray-600 hover:text-gray-900 font-semibold px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-200 transition"
                        >
                            Buka Semua
                        </button>
                        <button
                            type="button"
                            @click="collapseAll"
                            class="text-xs text-gray-600 hover:text-gray-900 font-semibold px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-200 transition"
                        >
                            Tutup Semua
                        </button>
                    </div>
                </div>

                <!-- Sections Accordion List -->
                <div
                    v-for="(section, index) in form.contents"
                    :key="section.id"
                    class="bg-white border border-gray-200/90 rounded-2xl shadow-2xs overflow-hidden transition"
                >
                    <!-- Section Header Toggle -->
                    <div
                        @click="toggleSection(section.section_key)"
                        class="px-6 py-4.5 bg-gray-50/70 hover:bg-gray-50 border-b border-gray-100 flex items-center justify-between cursor-pointer select-none transition"
                    >
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-blue-100 text-primary-700 text-xs font-bold flex items-center justify-center shrink-0">
                                {{ index + 1 }}
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    {{ sectionMeta[section.section_key]?.title || `Bagian: ${formatKeyName(section.section_key)}` }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ sectionMeta[section.section_key]?.desc || `Konfigurasi teks dan atribut untuk ${section.section_key}` }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <span
                                v-if="sectionMeta[section.section_key]?.badge"
                                class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-gray-200/80 text-gray-700 hidden sm:inline-block"
                            >
                                {{ sectionMeta[section.section_key]?.badge }}
                            </span>
                            <ChevronDown
                                :class="[
                                    'w-4 h-4 text-gray-400 transition-transform duration-200',
                                    openSections[section.section_key] ? 'rotate-180 text-gray-700' : ''
                                ]"
                            />
                        </div>
                    </div>

                    <!-- Section Body Content (Collapsible) -->
                    <div
                        v-show="openSections[section.section_key]"
                        class="p-6 sm:p-8 space-y-6"
                    >
                        <!-- Standard Title Field -->
                        <div v-if="section.title !== null">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                Judul Utama (Headline / Title)
                            </label>
                            <input
                                type="text"
                                v-model="section.title"
                                class="w-full text-sm rounded-xl border-gray-300 shadow-2xs focus:border-primary-500 focus:ring-primary-500 px-3.5 py-2.5 transition"
                                placeholder="Masukkan judul bagian..."
                            />
                        </div>

                        <!-- Standard Subtitle Field -->
                        <div v-if="section.subtitle !== null">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                Sub-Judul (Subtitle / Ringkasan)
                            </label>
                            <textarea
                                v-model="section.subtitle"
                                rows="3"
                                class="w-full text-sm rounded-xl border-gray-300 shadow-2xs focus:border-primary-500 focus:ring-primary-500 px-3.5 py-2.5 transition"
                                placeholder="Masukkan ringkasan penjelasan..."
                            ></textarea>
                        </div>

                        <!-- Special Showcase Notice -->
                        <div
                            v-if="section.section_key === 'showcase'"
                            class="p-4 bg-blue-50/70 border border-blue-200/80 rounded-xl text-xs text-blue-900 space-y-2"
                        >
                            <div class="font-bold flex items-center justify-between">
                                <span>📱 Mockup Komputer & Tablet Aktif</span>
                                <button
                                    type="button"
                                    @click="resetShowcaseToDefault(section)"
                                    class="inline-flex items-center gap-1 text-[11px] font-semibold text-primary-700 hover:underline"
                                >
                                    <RotateCcw class="w-3 h-3" /> Kembalikan ke Mockup SVG Bawaan
                                </button>
                            </div>
                            <p class="text-blue-800 leading-relaxed">
                                Bagian ini secara default menampilkan ilustrasi vektor presisi frame Komputer Backoffice dan Tablet Kasir Sollu POS (<code>/img/showcase-devices.svg</code>). Anda juga dapat mengunggah tangkapan layar sistem Anda sendiri di bawah.
                            </p>
                        </div>

                        <!-- Dynamic Attributes (JSONB) -->
                        <div
                            v-if="section.attributes"
                            class="pt-6 border-t border-gray-100"
                        >
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-5">
                                Pengaturan Ekstra (Attributes)
                            </h4>

                            <div class="space-y-6">
                                <div
                                    v-for="(attrValue, attrKey) in section.attributes"
                                    :key="attrKey"
                                    class="p-4 rounded-xl bg-gray-50/80 border border-gray-100"
                                >
                                    <!-- Array of Objects (e.g. stats, items, tabs, plans, reviews) -->
                                    <div
                                        v-if="Array.isArray(attrValue)"
                                        class="space-y-4"
                                    >
                                        <div class="flex items-center justify-between">
                                            <label class="text-xs font-bold uppercase tracking-wider text-gray-800">
                                                Daftar {{ formatKeyName(attrKey) }} ({{ attrValue.length }} Item)
                                            </label>
                                            <button
                                                type="button"
                                                @click="addArrayItem(section, attrKey)"
                                                class="inline-flex items-center gap-1 text-xs font-bold text-primary-700 bg-white border border-primary-200 px-3 py-1.5 rounded-lg hover:bg-primary-50 transition shadow-2xs"
                                            >
                                                <Plus class="w-3.5 h-3.5" /> Tambah {{ formatKeyName(attrKey) }}
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <div
                                                v-for="(item, iIndex) in attrValue"
                                                :key="iIndex"
                                                class="p-4 sm:p-5 border border-gray-200 rounded-xl bg-white space-y-3.5 shadow-2xs relative"
                                            >
                                                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                                    <span class="text-xs font-bold text-gray-700">
                                                        Item #{{ iIndex + 1 }}
                                                        <span v-if="item.title || item.name || item.label" class="text-gray-400 font-normal">
                                                            — {{ item.title || item.name || item.label }}
                                                        </span>
                                                    </span>
                                                    <button
                                                        type="button"
                                                        @click="removeArrayItem(section, attrKey, iIndex)"
                                                        class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-800 font-semibold px-2 py-1 rounded hover:bg-red-50 transition"
                                                    >
                                                        <Trash2 class="w-3 h-3" /> Hapus
                                                    </button>
                                                </div>

                                                <!-- Sub Values inside Item Object -->
                                                <div
                                                    v-for="(subVal, subKey) in item"
                                                    :key="subKey"
                                                >
                                                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                                                        {{ formatKeyName(subKey) }}
                                                    </label>

                                                    <!-- String Input (with upload if image/avatar/photo) -->
                                                    <div v-if="typeof subVal === 'string'" class="space-y-2">
                                                        <div class="flex items-center gap-2">
                                                            <input
                                                                type="text"
                                                                v-model="section.attributes[attrKey][iIndex][subKey]"
                                                                class="flex-1 text-sm rounded-lg border-gray-300 shadow-2xs focus:border-primary-500 focus:ring-primary-500 px-3 py-2"
                                                            />
                                                            <div
                                                                v-if="
                                                                    subKey.toLowerCase().includes('image') ||
                                                                    subKey.toLowerCase().includes('avatar') ||
                                                                    subKey.toLowerCase().includes('photo')
                                                                "
                                                                class="relative overflow-hidden inline-block shrink-0"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 flex items-center gap-1.5 transition"
                                                                >
                                                                    <Upload class="w-3 h-3" /> Upload
                                                                </button>
                                                                <input
                                                                    type="file"
                                                                    @change="
                                                                        (e) => {
                                                                            const f = e.target.files[0];
                                                                            if (!f) return;
                                                                            const fd = new FormData();
                                                                            fd.append('image', f);
                                                                            axios.post(route('admin.upload'), fd).then(res => {
                                                                                section.attributes[attrKey][iIndex][subKey] = res.data.url;
                                                                            }).catch(() => alert('Gagal upload gambar'));
                                                                            e.target.value = '';
                                                                        }
                                                                    "
                                                                    accept="image/*"
                                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="(subKey.toLowerCase().includes('image') || subKey.toLowerCase().includes('avatar')) && section.attributes[attrKey][iIndex][subKey]"
                                                            class="pt-1 flex items-center gap-3"
                                                        >
                                                            <img
                                                                :src="section.attributes[attrKey][iIndex][subKey]"
                                                                class="h-14 w-auto rounded-lg object-cover border border-gray-200 bg-white shadow-2xs"
                                                            />
                                                            <span class="text-[11px] text-gray-500 break-all">
                                                                {{ section.attributes[attrKey][iIndex][subKey] }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Boolean Input (e.g. is_popular) -->
                                                    <div
                                                        v-else-if="typeof subVal === 'boolean'"
                                                        class="flex items-center gap-2.5 pt-1"
                                                    >
                                                        <input
                                                            type="checkbox"
                                                            v-model="section.attributes[attrKey][iIndex][subKey]"
                                                            class="rounded text-primary-600 focus:ring-primary-500 border-gray-300 shadow-2xs w-4 h-4"
                                                        />
                                                        <span class="text-xs font-semibold text-gray-700">
                                                            Tandai Paling Populer / Aktif
                                                        </span>
                                                    </div>

                                                    <!-- Sub-Array of Strings (e.g. features checklist) -->
                                                    <div
                                                        v-else-if="Array.isArray(subVal)"
                                                        class="space-y-2 pt-1"
                                                    >
                                                        <div
                                                            v-for="(strVal, strIndex) in section.attributes[attrKey][iIndex][subKey]"
                                                            :key="strIndex"
                                                            class="flex gap-2 items-center"
                                                        >
                                                            <input
                                                                type="text"
                                                                v-model="section.attributes[attrKey][iIndex][subKey][strIndex]"
                                                                class="flex-1 text-xs rounded-lg border-gray-300 shadow-2xs focus:border-primary-500 focus:ring-primary-500 px-3 py-1.5"
                                                                placeholder="Fitur / Poin..."
                                                            />
                                                            <button
                                                                @click.prevent="section.attributes[attrKey][iIndex][subKey].splice(strIndex, 1)"
                                                                type="button"
                                                                class="p-1 px-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition"
                                                            >
                                                                ×
                                                            </button>
                                                        </div>
                                                        <button
                                                            @click.prevent="section.attributes[attrKey][iIndex][subKey].push('')"
                                                            type="button"
                                                            class="text-xs font-semibold text-primary-700 hover:text-primary-800 bg-primary-50 px-2.5 py-1 rounded-md inline-flex items-center gap-1 transition"
                                                        >
                                                            <Plus class="w-3 h-3" /> Tambah Poin Fitur
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single String Attribute (e.g. badge, eyebrow, button_text, image_url) -->
                                    <div v-else-if="typeof attrValue === 'string'">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            {{ formatKeyName(attrKey) }}
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input
                                                type="text"
                                                v-model="section.attributes[attrKey]"
                                                class="flex-1 text-sm rounded-xl border-gray-300 shadow-2xs focus:border-primary-500 focus:ring-primary-500 px-3.5 py-2.5"
                                            />

                                            <!-- Inline Upload Button for Image Fields -->
                                            <div
                                                v-if="
                                                    attrKey.toLowerCase().includes('image') ||
                                                    attrKey.toLowerCase().includes('logo')
                                                "
                                                class="relative overflow-hidden inline-block shrink-0"
                                            >
                                                <button
                                                    type="button"
                                                    class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-xl text-xs font-semibold text-gray-700 flex items-center gap-1.5 transition"
                                                >
                                                    <Upload class="w-3.5 h-3.5" /> Upload File
                                                </button>
                                                <input
                                                    type="file"
                                                    @change="(e) => uploadImage(e, section, attrKey)"
                                                    accept="image/*"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            v-if="attrKey.toLowerCase().includes('image') && section.attributes[attrKey]"
                                            class="mt-3 flex items-center gap-4 bg-white p-3 rounded-xl border border-gray-200/80"
                                        >
                                            <img
                                                :src="section.attributes[attrKey]"
                                                class="h-16 w-auto max-w-xs rounded-lg object-contain border border-gray-100"
                                            />
                                            <div class="text-xs text-gray-500 break-all">
                                                Path gambar: <span class="font-mono text-gray-800">{{ section.attributes[attrKey] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Sticky Submit Bar -->
                <div class="sticky bottom-6 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-gray-200 shadow-lg flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Jangan lupa klik simpan setelah melakukan perubahan teks atau aset visual.
                    </div>
                    <button
                        @click="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 transition shadow-xs disabled:opacity-50"
                    >
                        {{ form.processing ? "Menyimpan..." : "Simpan Perubahan" }}
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

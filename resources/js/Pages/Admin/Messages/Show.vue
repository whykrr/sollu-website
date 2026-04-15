<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    ArrowLeft,
    Mail,
    MailOpen,
    Trash2,
    Phone,
    Building2,
    AtSign,
    MessageSquare,
    Clock,
    ExternalLink,
    Send,
    Reply,
    CheckCircle2,
    User,
} from "lucide-vue-next";

const props = defineProps({
    message: Object,
});

const showReplyForm = ref(false);

const replyForm = useForm({
    reply_subject: `Re: Balasan untuk pesan dari ${props.message.name}`,
    reply_message: "",
});

const submitReply = () => {
    replyForm.post(route("admin.messages.reply", props.message.id), {
        preserveScroll: true,
        onSuccess: () => {
            showReplyForm.value = false;
            replyForm.reset("reply_message");
        },
    });
};

const toggleRead = () => {
    router.patch(
        route("admin.messages.toggleRead", props.message.id),
        {},
        { preserveState: false },
    );
};

const deleteMessage = () => {
    if (
        confirm(`Yakin ingin menghapus pesan dari "${props.message.name}"?`)
    ) {
        router.delete(route("admin.messages.destroy", props.message.id));
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return "-";
    return new Date(dateStr).toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const waLink = (phone) => {
    if (!phone) return "#";
    const clean = phone.replace(/\D/g, "");
    const formatted = clean.startsWith("0") ? "62" + clean.slice(1) : clean;
    return `https://wa.me/${formatted}`;
};
</script>

<template>
    <Head :title="`CMS | Pesan dari ${message.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('admin.messages.index')"
                        class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-500 hover:text-gray-700"
                    >
                        <ArrowLeft class="w-5 h-5" />
                    </Link>
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Detail Pesan
                    </h2>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Reply Button -->
                    <button
                        v-if="message.email && !message.replied_at"
                        @click="showReplyForm = !showReplyForm"
                        :class="[
                            'inline-flex items-center gap-2 px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest transition',
                            showReplyForm
                                ? 'bg-primary-600 border-transparent text-white hover:bg-primary-700'
                                : 'bg-white border-primary-300 text-primary-700 hover:bg-primary-50',
                        ]"
                    >
                        <Reply class="w-4 h-4" />
                        {{ showReplyForm ? "Tutup Form" : "Balas via Email" }}
                    </button>
                    <button
                        @click="toggleRead"
                        :class="[
                            'inline-flex items-center gap-2 px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest transition',
                            message.is_read
                                ? 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
                                : 'bg-green-600 border-transparent text-white hover:bg-green-700',
                        ]"
                    >
                        <MailOpen v-if="message.is_read" class="w-4 h-4" />
                        <Mail v-else class="w-4 h-4" />
                        {{
                            message.is_read
                                ? "Tandai Belum Dibaca"
                                : "Tandai Sudah Dibaca"
                        }}
                    </button>
                    <button
                        @click="deleteMessage"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition"
                    >
                        <Trash2 class="w-4 h-4" /> Hapus
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center gap-2"
                >
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    {{ $page.props.flash.success }}
                </div>
                <div
                    v-if="$page.props.flash?.error"
                    class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200"
                >
                    {{ $page.props.flash.error }}
                </div>

                <!-- Status Badge -->
                <div class="mb-6 flex items-center gap-3 flex-wrap">
                    <span
                        v-if="message.is_read"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700 border border-green-200"
                    >
                        <MailOpen class="w-4 h-4" /> Sudah Dibaca
                    </span>
                    <span
                        v-else
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-amber-50 text-amber-700 border border-amber-200"
                    >
                        <Mail class="w-4 h-4" /> Belum Dibaca
                    </span>
                    <span
                        v-if="message.replied_at"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-primary-50 text-primary-700 border border-primary-200"
                    >
                        <Reply class="w-4 h-4" /> Sudah Dibalas
                    </span>
                    <span class="text-sm text-gray-400 flex items-center gap-1">
                        <Clock class="w-4 h-4" />
                        {{ formatDate(message.created_at) }}
                    </span>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <!-- Contact Info Sidebar -->
                    <div class="lg:col-span-1 space-y-4">
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
                        >
                            <h3
                                class="font-bold text-gray-900 text-lg mb-4"
                            >
                                Info Pengirim
                            </h3>

                            <div class="space-y-4">
                                <!-- Name -->
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-primary-50 flex items-center justify-center shrink-0"
                                    >
                                        <MessageSquare
                                            class="w-4 h-4 text-primary-600"
                                        />
                                    </div>
                                    <div>
                                        <p
                                            class="text-xs text-gray-400 uppercase tracking-wider"
                                        >
                                            Nama
                                        </p>
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ message.name }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Business -->
                                <div
                                    v-if="message.business_name"
                                    class="flex items-start gap-3"
                                >
                                    <div
                                        class="w-9 h-9 rounded-lg bg-primary-50 flex items-center justify-center shrink-0"
                                    >
                                        <Building2
                                            class="w-4 h-4 text-primary-600"
                                        />
                                    </div>
                                    <div>
                                        <p
                                            class="text-xs text-gray-400 uppercase tracking-wider"
                                        >
                                            Bisnis
                                        </p>
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ message.business_name }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center shrink-0"
                                    >
                                        <Phone
                                            class="w-4 h-4 text-green-600"
                                        />
                                    </div>
                                    <div>
                                        <p
                                            class="text-xs text-gray-400 uppercase tracking-wider"
                                        >
                                            Telepon / WA
                                        </p>
                                        <p
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ message.phone }}
                                        </p>
                                        <a
                                            :href="waLink(message.phone)"
                                            target="_blank"
                                            class="inline-flex items-center gap-1 text-xs text-green-600 hover:text-green-800 font-medium mt-1 transition"
                                        >
                                            <ExternalLink
                                                class="w-3 h-3"
                                            />
                                            Hubungi via WhatsApp
                                        </a>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div
                                    v-if="message.email"
                                    class="flex items-start gap-3"
                                >
                                    <div
                                        class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0"
                                    >
                                        <AtSign
                                            class="w-4 h-4 text-blue-600"
                                        />
                                    </div>
                                    <div>
                                        <p
                                            class="text-xs text-gray-400 uppercase tracking-wider"
                                        >
                                            Email
                                        </p>
                                        <a
                                            :href="
                                                'mailto:' + message.email
                                            "
                                            class="text-sm font-semibold text-primary-600 hover:text-primary-800 transition"
                                        >
                                            {{ message.email }}
                                        </a>
                                    </div>
                                </div>

                                <!-- No Email Warning -->
                                <div
                                    v-if="!message.email"
                                    class="p-3 bg-amber-50 rounded-lg border border-amber-200"
                                >
                                    <p class="text-xs text-amber-700 font-medium">
                                        ⚠️ Pengirim tidak mencantumkan email. Balas melalui WhatsApp.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Original Message -->
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-8"
                        >
                            <h3
                                class="font-bold text-gray-900 text-lg mb-4 flex items-center gap-2"
                            >
                                <MessageSquare
                                    class="w-5 h-5 text-primary-600"
                                />
                                Isi Pesan
                            </h3>
                            <div
                                class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 rounded-lg p-6 border border-gray-100"
                            >
                                {{ message.message }}
                            </div>
                        </div>

                        <!-- Previous Reply (if exists) -->
                        <div
                            v-if="message.replied_at"
                            class="bg-white rounded-xl shadow-sm border border-primary-200 p-8"
                        >
                            <div class="flex items-center justify-between mb-4">
                                <h3
                                    class="font-bold text-gray-900 text-lg flex items-center gap-2"
                                >
                                    <Reply class="w-5 h-5 text-primary-600" />
                                    Balasan Terkirim
                                </h3>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700"
                                >
                                    <CheckCircle2 class="w-3.5 h-3.5" />
                                    Terkirim
                                </span>
                            </div>

                            <!-- Reply Meta -->
                            <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <Clock class="w-4 h-4" />
                                    {{ formatDate(message.replied_at) }}
                                </span>
                                <span
                                    v-if="message.replied_by_user"
                                    class="flex items-center gap-1.5"
                                >
                                    <User class="w-4 h-4" />
                                    oleh {{ message.replied_by_user.name }}
                                </span>
                            </div>

                            <!-- Reply Subject -->
                            <div class="mb-3">
                                <span class="text-xs text-gray-400 uppercase tracking-wider">Subjek</span>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">
                                    {{ message.reply_subject }}
                                </p>
                            </div>

                            <!-- Reply Body -->
                            <div
                                class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-line bg-primary-50/50 rounded-lg p-6 border border-primary-100"
                            >
                                {{ message.reply_message }}
                            </div>
                        </div>

                        <!-- Reply Form -->
                        <div
                            v-if="showReplyForm && message.email"
                            class="bg-white rounded-xl shadow-sm border-2 border-primary-200 p-8"
                        >
                            <h3
                                class="font-bold text-gray-900 text-lg mb-1 flex items-center gap-2"
                            >
                                <Reply class="w-5 h-5 text-primary-600" />
                                {{ message.replied_at ? 'Kirim Balasan Ulang' : 'Balas Pesan' }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-6">
                                Balasan akan dikirim ke
                                <strong class="text-gray-700">{{ message.email }}</strong>
                            </p>

                            <form @submit.prevent="submitReply">
                                <!-- Subject -->
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Subjek Email <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        v-model="replyForm.reply_subject"
                                        required
                                        class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white"
                                        :class="{ 'border-red-500': replyForm.errors.reply_subject }"
                                        placeholder="Subjek email balasan..."
                                    />
                                    <p v-if="replyForm.errors.reply_subject" class="mt-1 text-sm text-red-600">
                                        {{ replyForm.errors.reply_subject }}
                                    </p>
                                </div>

                                <!-- Reply Message -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Isi Balasan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        rows="8"
                                        v-model="replyForm.reply_message"
                                        required
                                        class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition px-4 py-3 bg-gray-50 focus:bg-white"
                                        :class="{ 'border-red-500': replyForm.errors.reply_message }"
                                        placeholder="Tulis balasan Anda di sini..."
                                    ></textarea>
                                    <p v-if="replyForm.errors.reply_message" class="mt-1 text-sm text-red-600">
                                        {{ replyForm.errors.reply_message }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-3">
                                    <button
                                        type="submit"
                                        :disabled="replyForm.processing"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-primary-700 transition disabled:opacity-70 disabled:cursor-not-allowed shadow-sm"
                                    >
                                        <Send v-if="!replyForm.processing" class="w-4 h-4" />
                                        <svg v-else class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ replyForm.processing ? 'Mengirim...' : 'Kirim Balasan Email' }}
                                    </button>
                                    <button
                                        type="button"
                                        @click="showReplyForm = false"
                                        class="px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 transition"
                                    >
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Reply CTA for messages with email but not yet replied -->
                        <div
                            v-if="!showReplyForm && message.email && !message.replied_at"
                            class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-8 text-center"
                        >
                            <Reply class="w-8 h-8 text-gray-400 mx-auto mb-3" />
                            <p class="text-gray-600 font-medium mb-1">Belum ada balasan untuk pesan ini</p>
                            <p class="text-sm text-gray-400 mb-4">Klik tombol di bawah untuk membalas via email</p>
                            <button
                                @click="showReplyForm = true"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white rounded-lg font-semibold text-sm hover:bg-primary-700 transition shadow-sm"
                            >
                                <Reply class="w-4 h-4" />
                                Balas via Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

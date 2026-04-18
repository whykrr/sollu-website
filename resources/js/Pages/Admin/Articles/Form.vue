<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Image from "@tiptap/extension-image";
import TiptapLink from "@tiptap/extension-link";
import { ref, watch, onBeforeUnmount } from "vue";
import axios from "axios";
import {
    Bold,
    Italic,
    Strikethrough,
    List,
    ListOrdered,
    Heading1,
    Heading2,
    Heading3,
    Quote,
    Undo,
    Redo,
    ImagePlus,
    Link2,
    Code,
    Minus,
    Upload,
} from "lucide-vue-next";

const props = defineProps({
    article: { type: Object, default: null },
    categories: Array,
});

const isEditing = !!props.article;

const form = useForm({
    title: props.article?.title || "",
    excerpt: props.article?.excerpt || "",
    content: props.article?.content || "",
    category_id: props.article?.category_id || "",
    image_url: props.article?.image_url || "",
    published_at: props.article?.published_at
        ? props.article.published_at.substring(0, 16)
        : "",
});

// Tiptap Editor setup
const editor = useEditor({
    extensions: [
        StarterKit,
        Image.configure({ inline: false, allowBase64: false }),
        TiptapLink.configure({ openOnClick: false }),
    ],
    content: form.content,
    onUpdate: ({ editor }) => {
        form.content = editor.getHTML();
    },
    editorProps: {
        attributes: {
            class: "prose prose-sm max-w-none focus:outline-none min-h-[300px] px-4 py-3",
        },
    },
});

onBeforeUnmount(() => {
    editor.value?.destroy();
});

const submit = () => {
    if (isEditing) {
        form.put(route("admin.articles.update", props.article.id));
    } else {
        form.post(route("admin.articles.store"));
    }
};

const publishNow = () => {
    form.published_at = new Date().toISOString().substring(0, 16);
};

const saveDraft = () => {
    form.published_at = "";
};

// Image compression helper (max 500kb auto)
const compressImage = async (file, maxSizeKB = 500) => {
    return new Promise((resolve) => {
        const maxSize = maxSizeKB * 1024;
        if (file.size <= maxSize) return resolve(file); // Sudah cukup kecil

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (event) => {
            const img = new window.Image();
            img.src = event.target.result;
            img.onload = () => {
                const canvas = document.createElement("canvas");
                let width = img.width;
                let height = img.height;

                // Max resolution bounding
                const maxDim = 1920;
                if (width > maxDim || height > maxDim) {
                    if (width > height) {
                        height = Math.round((height *= maxDim / width));
                        width = maxDim;
                    } else {
                        width = Math.round((width *= maxDim / height));
                        height = maxDim;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);

                let quality = 0.9;
                const compress = () => {
                    canvas.toBlob(
                        (blob) => {
                            if (blob.size <= maxSize || quality <= 0.3) {
                                const newFile = new File([blob], file.name, {
                                    type: "image/jpeg",
                                    lastModified: Date.now(),
                                });
                                resolve(newFile);
                            } else {
                                quality -= 0.15; // Turunkan kualitas bertahap
                                compress();
                            }
                        },
                        "image/jpeg",
                        quality
                    );
                };
                compress();
            };
        };
    });
};

// Cover image upload
const uploadingCover = ref(false);
const uploadCover = async (event) => {
    const file = event.target.files[0];
    if (!file) return;
    uploadingCover.value = true;

    try {
        const compressedFile = await compressImage(file, 500);

        const formData = new FormData();
        formData.append("image", compressedFile);

        const response = await axios.post(route("admin.upload"), formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        form.image_url = response.data.url;
    } catch (error) {
        alert("Gagal mengupload gambar cover.");
    } finally {
        uploadingCover.value = false;
        event.target.value = "";
    }
};

// Toolbar image insert for editor
const insertEditorImage = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    try {
        const compressedFile = await compressImage(file, 500);

        const formData = new FormData();
        formData.append("image", compressedFile);

        const response = await axios.post(route("admin.upload"), formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        editor.value
            ?.chain()
            .focus()
            .setImage({ src: response.data.url })
            .run();
    } catch (error) {
        alert("Gagal mengupload gambar.");
    } finally {
        event.target.value = "";
    }
};

const setLink = () => {
    const url = prompt("Masukkan URL:");
    if (url) {
        editor.value?.chain().focus().setLink({ href: url }).run();
    }
};
</script>

<template>
    <Head
        :title="`CMS | ` + isEditing ? 'Edit Artikel' : 'Tulis Artikel Baru'"
    />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ isEditing ? "Edit Artikel" : "Tulis Artikel Baru" }}
                </h2>
                <Link
                    :href="route('admin.articles.index')"
                    class="text-sm text-gray-500 hover:text-gray-700 transition"
                >
                    ← Kembali ke Daftar
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200"
                >
                    {{ $page.props.flash.success }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content Column -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Title -->
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Judul Artikel</label
                                >
                                <input
                                    type="text"
                                    v-model="form.title"
                                    required
                                    placeholder="Masukkan judul artikel..."
                                    class="w-full text-xl font-bold rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                />
                                <div
                                    v-if="form.errors.title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Ringkasan (Excerpt)</label
                                >
                                <textarea
                                    v-model="form.excerpt"
                                    rows="2"
                                    placeholder="Ringkasan singkat untuk card preview..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                ></textarea>
                            </div>

                            <!-- Rich Text Editor -->
                            <div
                                class="bg-white shadow sm:rounded-lg overflow-hidden"
                            >
                                <label
                                    class="block text-sm font-medium text-gray-700 px-6 pt-6 pb-2"
                                    >Konten Artikel</label
                                >

                                <!-- Toolbar -->
                                <div
                                    v-if="editor"
                                    class="flex flex-wrap items-center gap-1 border-b border-gray-200 px-4 py-2 bg-gray-50"
                                >
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleBold()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('bold'),
                                            },
                                        ]"
                                    >
                                        <Bold class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleItalic()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('italic'),
                                            },
                                        ]"
                                    >
                                        <Italic class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleStrike()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('strike'),
                                            },
                                        ]"
                                    >
                                        <Strikethrough class="w-4 h-4" />
                                    </button>
                                    <div
                                        class="w-px h-5 bg-gray-300 mx-1"
                                    ></div>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleHeading({ level: 2 })
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition text-xs font-bold',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('heading', {
                                                        level: 2,
                                                    }),
                                            },
                                        ]"
                                    >
                                        H2
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleHeading({ level: 3 })
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition text-xs font-bold',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('heading', {
                                                        level: 3,
                                                    }),
                                            },
                                        ]"
                                    >
                                        H3
                                    </button>
                                    <div
                                        class="w-px h-5 bg-gray-300 mx-1"
                                    ></div>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleBulletList()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive(
                                                        'bulletList',
                                                    ),
                                            },
                                        ]"
                                    >
                                        <List class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleOrderedList()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive(
                                                        'orderedList',
                                                    ),
                                            },
                                        ]"
                                    >
                                        <ListOrdered class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleBlockquote()
                                                .run()
                                        "
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive(
                                                        'blockquote',
                                                    ),
                                            },
                                        ]"
                                    >
                                        <Quote class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .setHorizontalRule()
                                                .run()
                                        "
                                        class="p-1.5 rounded hover:bg-gray-200 transition"
                                    >
                                        <Minus class="w-4 h-4" />
                                    </button>
                                    <div
                                        class="w-px h-5 bg-gray-300 mx-1"
                                    ></div>
                                    <button
                                        type="button"
                                        @click="setLink"
                                        :class="[
                                            'p-1.5 rounded hover:bg-gray-200 transition',
                                            {
                                                'bg-gray-200 text-primary-700':
                                                    editor.isActive('link'),
                                            },
                                        ]"
                                    >
                                        <Link2 class="w-4 h-4" />
                                    </button>
                                    <div
                                        class="relative overflow-hidden inline-block"
                                    >
                                        <button
                                            type="button"
                                            class="p-1.5 rounded hover:bg-gray-200 transition"
                                        >
                                            <ImagePlus class="w-4 h-4" />
                                        </button>
                                        <input
                                            type="file"
                                            @change="insertEditorImage"
                                            accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        />
                                    </div>
                                    <div
                                        class="w-px h-5 bg-gray-300 mx-1"
                                    ></div>
                                    <button
                                        type="button"
                                        @click="
                                            editor.chain().focus().undo().run()
                                        "
                                        class="p-1.5 rounded hover:bg-gray-200 transition"
                                    >
                                        <Undo class="w-4 h-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            editor.chain().focus().redo().run()
                                        "
                                        class="p-1.5 rounded hover:bg-gray-200 transition"
                                    >
                                        <Redo class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Editor Content -->
                                <EditorContent
                                    :editor="editor"
                                    class="border-0"
                                />
                                <div
                                    v-if="form.errors.content"
                                    class="px-6 pb-4 text-sm text-red-600"
                                >
                                    {{ form.errors.content }}
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1 space-y-6">
                            <!-- Publish Settings -->
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                <h3
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4"
                                >
                                    Publikasi
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                            >Tanggal Publish</label
                                        >
                                        <input
                                            type="datetime-local"
                                            v-model="form.published_at"
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                        />
                                    </div>

                                    <div class="flex gap-2">
                                        <button
                                            type="button"
                                            @click="publishNow"
                                            class="flex-1 px-3 py-2 text-xs font-bold bg-green-50 text-green-700 rounded-md hover:bg-green-100 transition"
                                        >
                                            Publish Sekarang
                                        </button>
                                        <button
                                            type="button"
                                            @click="saveDraft"
                                            class="flex-1 px-3 py-2 text-xs font-bold bg-yellow-50 text-yellow-700 rounded-md hover:bg-yellow-100 transition"
                                        >
                                            Set Draft
                                        </button>
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full mt-6 px-4 py-3 bg-primary-600 text-white font-bold rounded-md hover:bg-primary-700 transition disabled:opacity-50"
                                >
                                    {{
                                        form.processing
                                            ? "Menyimpan..."
                                            : isEditing
                                              ? "Simpan Perubahan"
                                              : "Simpan Artikel"
                                    }}
                                </button>
                            </div>

                            <!-- Category -->
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                <h3
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4"
                                >
                                    Kategori
                                </h3>
                                <select
                                    v-model="form.category_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                >
                                    <option value="">— Tanpa Kategori —</option>
                                    <option
                                        v-for="cat in categories"
                                        :key="cat.id"
                                        :value="cat.id"
                                    >
                                        {{ cat.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Cover Image -->
                            <div class="bg-white shadow sm:rounded-lg p-6">
                                <h3
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4"
                                >
                                    Gambar Cover
                                </h3>

                                <div v-if="form.image_url" class="mb-4">
                                    <img
                                        :src="form.image_url"
                                        class="w-full h-40 object-cover rounded-lg border border-gray-200"
                                    />
                                </div>

                                <div class="relative">
                                    <button
                                        type="button"
                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-sm text-gray-500 hover:border-primary-400 hover:text-primary-600 transition flex items-center justify-center gap-2"
                                    >
                                        <Upload class="w-4 h-4" />
                                        {{
                                            uploadingCover
                                                ? "Mengupload..."
                                                : form.image_url
                                                  ? "Ganti Gambar"
                                                  : "Upload Gambar Cover"
                                        }}
                                    </button>
                                    <input
                                        type="file"
                                        @change="uploadCover"
                                        accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        :disabled="uploadingCover"
                                    />
                                </div>

                                <input
                                    type="text"
                                    v-model="form.image_url"
                                    placeholder="atau paste URL gambar..."
                                    class="w-full mt-3 text-xs rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

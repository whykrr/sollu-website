<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object,
});

// Convert the keyed object back to an array for submission
const formData = Object.values(props.settings).map(setting => ({
    key: setting.key,
    value: setting.value,
    type: setting.type
}));

const form = useForm({
    settings: formData
});

const submit = () => {
    form.put(route('admin.settings.update'), {
        preserveScroll: true,
    });
};

const formatKeyName = (key) => {
    return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};
</script>

<template>
    <Head title="Pengaturan Situs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Pengaturan Global Situs
                </h2>
                <button @click="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 space-y-6">
                <!-- Success Message -->
                <div v-if="$page.props.flash?.success" class="p-4 bg-green-50 text-green-700 rounded-lg">
                    {{ $page.props.flash.success }}
                </div>

                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Variabel Konfigurasi Global</h3>
                        <p class="text-sm text-gray-500 mt-1">Ubah tautan eksternal atau kontak yang sering berubah di sini agar tercermin di seluruh website.</p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div v-for="(setting, index) in form.settings" :key="setting.key">
                            <label class="block text-sm font-medium text-gray-700 mb-1 capitalize">{{ formatKeyName(setting.key) }}</label>
                            
                            <!-- Input based on type -->
                            <div v-if="setting.type === 'text' || setting.type === 'url'">
                                <input :type="setting.type === 'url' ? 'url' : 'text'" v-model="form.settings[index].value" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div v-else-if="setting.type === 'boolean'">
                                <select v-model="form.settings[index].value" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="1">Aktif (Yes)</option>
                                    <option value="0">Tidak Aktif (No)</option>
                                </select>
                            </div>
                            <div v-else>
                                <textarea v-model="form.settings[index].value" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                            </div>
                            
                            <p class="mt-1 text-xs text-gray-400">Key Identifier: <code>{{ setting.key }}</code></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

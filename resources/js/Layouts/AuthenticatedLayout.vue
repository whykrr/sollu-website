<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { 
    LayoutDashboard, FileText, Search, LibraryBig, MessageSquare, 
    Settings, Users, Menu, X, FolderTree, HelpCircle
} from "lucide-vue-next";

const showingSidebar = ref(false);
const page = usePage();

const menuItems = [
    { name: 'Dashboard', route: 'admin.dashboard', icon: LayoutDashboard },
    { name: 'Kelola Halaman', route: 'admin.pages.index', icon: FileText, gate: ['superadmin', 'admin'] },
    { name: 'Artikel', route: 'admin.articles.index', icon: LibraryBig },
    { name: 'FAQ', route: 'admin.faqs.index', icon: HelpCircle },
    { name: 'Kategori', route: 'admin.categories.index', icon: FolderTree },
    { name: 'Pesan Masuk', route: 'admin.messages.index', icon: MessageSquare },
    { name: 'Pengaturan Situs', route: 'admin.settings.index', icon: Settings, gate: ['superadmin', 'admin'] },
    { name: 'SEO', route: 'admin.seo.index', icon: Search, gate: ['superadmin', 'admin'] },
    { name: 'Pengguna', route: 'admin.users.index', icon: Users, gate: ['superadmin'] },
];

const hasAccess = (item) => {
    if (!item.gate) return true;
    return item.gate.includes(page.props.auth.user.role);
};
</script>

<template>
    <Head>
        <link rel="icon" type="image/png" href="/img/icon-dark.png" />
    </Head>
    <div class="h-screen flex overflow-hidden bg-gray-50">
        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:inset-y-0 md:fixed bg-primary-800 text-white shadow-xl">
            <div class="flex-1 flex flex-col min-h-0 bg-[#1e40af]">
                <div class="flex items-center h-16 shrink-0 px-6 bg-black/10 border-b border-black/10">
                    <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                        <img src="/img/logo-white.png" alt="Sollu POS" class="h-8 w-auto" />
                    </Link>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto py-6">
                    <nav class="flex-1 px-4 space-y-2">
                        <template v-for="item in menuItems" :key="item.name">
                            <Link v-if="hasAccess(item)" :href="route(item.route)" 
                                :class="[
                                    route().current(item.route.replace('.index', '.*')) || route().current(item.route) 
                                    ? 'bg-black/20 text-white shadow-sm ring-1 ring-white/10' 
                                    : 'text-primary-100 hover:bg-black/10 hover:text-white', 
                                    'group flex items-center px-3 py-3 text-sm font-semibold rounded-lg transition-all duration-200'
                                ]"
                            >
                                <component :is="item.icon" 
                                    :class="[
                                        route().current(item.route.replace('.index', '.*')) || route().current(item.route) 
                                        ? 'text-white' 
                                        : 'text-primary-200 group-hover:text-white', 
                                        'mr-3 shrink-0 h-5 w-5'
                                    ]" 
                                    aria-hidden="true" 
                                />
                                {{ item.name }}
                            </Link>
                        </template>
                    </nav>
                </div>
                
                <!-- Bottom Profile Tag in Sidebar -->
                <div class="flex-shrink-0 flex border-t border-black/10 p-4 bg-black/5">
                    <div class="flex items-center w-full">
                        <div>
                            <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white/20" :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=ffffff&color=1e40af`" alt="" />
                        </div>
                        <div class="ml-3 truncate">
                            <p class="text-sm font-medium text-white truncate">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs font-medium text-primary-200 truncate capitalize">{{ $page.props.auth.user.role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlays for Mobile -->
        <div v-show="showingSidebar" class="relative z-40 md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" @click="showingSidebar = false"></div>
            <div class="fixed inset-0 z-40 flex">
                <div class="relative flex w-full max-w-xs flex-1 flex-col bg-[#1e40af] shadow-2xl">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="showingSidebar = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white hover:bg-white/20 transition-colors">
                            <span class="sr-only">Close sidebar</span>
                            <X class="h-6 w-6 text-white" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="flex h-16 shrink-0 items-center px-6 bg-black/10">
                        <img src="/img/logo-white.png" alt="Sollu POS" class="h-8 w-auto" />
                    </div>
                    <div class="h-0 flex-1 overflow-y-auto py-6">
                        <nav class="px-4 space-y-2">
                            <template v-for="item in menuItems" :key="item.name">
                                <Link v-if="hasAccess(item)" :href="route(item.route)" 
                                    @click="showingSidebar = false"
                                    :class="[
                                        route().current(item.route.replace('.index', '.*')) || route().current(item.route) 
                                        ? 'bg-black/20 text-white shadow-sm ring-1 ring-white/10' 
                                        : 'text-primary-100 hover:bg-black/10 hover:text-white', 
                                        'group flex items-center px-3 py-3 font-semibold rounded-lg'
                                    ]"
                                >
                                    <component :is="item.icon" 
                                        :class="[
                                            route().current(item.route.replace('.index', '.*')) || route().current(item.route) 
                                            ? 'text-white' 
                                            : 'text-primary-200 group-hover:text-white', 
                                            'mr-4 shrink-0 h-6 w-6'
                                        ]" 
                                        aria-hidden="true" 
                                    />
                                    {{ item.name }}
                                </Link>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main column -->
        <div class="flex flex-col flex-1 w-full md:pl-64">
            
            <div class="sticky top-0 z-10 flex h-16 shrink-0 bg-white shadow-sm border-b border-gray-200">
                <button type="button" class="border-r border-gray-200 px-4 text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:outline-none md:hidden transition-colors" @click="showingSidebar = true">
                    <span class="sr-only">Open sidebar</span>
                    <Menu class="h-6 w-6" aria-hidden="true" />
                </button>
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-1 items-center">
                        <!-- Space for search or breadcrumbs -->
                    </div>
                    <div class="ml-4 flex items-center md:ml-6 gap-3">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button type="button" class="flex items-center gap-2 rounded-full bg-white p-1 text-sm focus:outline-none hover:bg-gray-50 transition border border-transparent hover:border-gray-200 px-3 py-1.5 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <span class="font-medium text-gray-700 hidden sm:block">{{ $page.props.auth.user.name }}</span>
                                    <svg class="hidden sm:block h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <img class="h-8 w-8 rounded-full shadow-sm" :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=1e40af&color=fff`" alt="Avatar"/>
                                </button>
                            </template>
                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-100 text-sm">
                                    <p class="font-medium text-gray-900 truncate">{{ $page.props.auth.user.name }}</p>
                                    <p class="text-gray-500 truncate">{{ $page.props.auth.user.email }}</p>
                                </div>
                                <DropdownLink :href="route('profile.edit')">Profil Anda</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Keluar</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 flex flex-col w-full">
                <!-- Page Heading -->
                <header class="bg-white shadow-sm border-b border-gray-200" v-if="$slots.header">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>
                
                <div class="flex-1 min-h-0 mx-auto max-w-7xl w-full">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { Link, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const isDarkMode = ref(false);
const isMobileMenuOpen = ref(false); // สำหรับเมนูมือถือ

// ฟังก์ชันสลับโหมด
const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

onMounted(() => {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    }
});
</script>

<template>
    <Head>
        <component :is="'script'" src="https://cdn.tailwindcss.com"></component>
        <component :is="'script'">
            tailwind.config = { 
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: { sans: ['Prompt', 'sans-serif'] }
                    }
                }
            }
        </component>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </Head>

    <div class="min-h-screen flex flex-col bg-slate-50 dark:bg-slate-900 dark:space-bg font-sans text-slate-600 dark:text-slate-300 transition-colors duration-300">
        
        <nav class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 fixed w-full z-50 transition-colors duration-300">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="flex justify-between items-center h-20">
                    
                    <Link :href="route('landing')" class="flex items-center group">
                        <div class="relative w-12 h-12 mr-3 transition-transform group-hover:scale-110">
                            <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="Logo" class="w-full h-full object-contain drop-shadow-md">
                        </div>
                        <div class="leading-tight">
                            <span class="block font-bold text-lg text-slate-800 dark:text-white tracking-tight">CMUCOOP</span>
                            <span class="block text-[10px] text-blue-600 dark:text-blue-400 font-semibold tracking-wider">MEMBER ZONE</span>
                        </div>
                    </Link>

                    <div class="hidden lg:flex items-center space-x-1">
                        <Link :href="route('member.home')" :class="['nav-item', route().current('member.home') ? 'active' : '']">
                            <i class="bi bi-house-door mr-1.5"></i> หน้าหลัก
                        </Link>
                        <Link :href="route('member')" :class="['nav-item', route().current('member') ? 'active' : '']">
                            <i class="bi bi-person-vcard mr-1.5"></i> สมาชิก
                        </Link>
                        <Link :href="route('board')" :class="['nav-item', route().current('board*') ? 'active' : '']">
                            <i class="bi bi-clipboard2-heart mr-1.5"></i> สวัสดิการ
                        </Link>
                        <Link :href="route('easypoint')" :class="['nav-item', route().current('easypoint*') ? 'active' : '']">
                            <i class="bi bi-coin mr-1.5"></i> EasyPoint
                        </Link>
                        <Link :href="route('check.member')" :class="['nav-item', route().current('check.member') ? 'active' : '']">
                            <i class="bi bi-search mr-1.5"></i> ตรวจสอบ
                        </Link>
                    </div>

                    <div class="flex items-center space-x-3">
                         <button @click="toggleTheme" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-700 transition-colors">
                            <i v-if="isDarkMode" class="bi bi-moon-stars-fill text-yellow-400"></i>
                            <i v-else class="bi bi-sun-fill text-orange-500"></i>
                        </button>

                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="lg:hidden p-2 text-slate-600 dark:text-slate-300">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="isMobileMenuOpen" class="lg:hidden bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 px-4 py-4 space-y-2 shadow-lg">
                <Link :href="route('member.home')" class="mobile-link">หน้าหลัก</Link>
                <Link :href="route('member')" class="mobile-link">ข้อมูลสมาชิก</Link>
                <Link :href="route('board')" class="mobile-link">สวัสดิการ</Link>
                <Link :href="route('easypoint')" class="mobile-link">EasyPoint</Link>
                <Link :href="route('check.member')" class="mobile-link">ตรวจสอบสมาชิก</Link>
            </div>
        </nav>

        <div class="pt-24 pb-12 px-4 container mx-auto relative z-10">
            <slot />
        </div>

        <footer class="bg-white dark:bg-slate-800/90 backdrop-blur-md border-t border-slate-200 dark:border-slate-700/50 pt-8 pb-6 mt-auto relative z-20 text-sm">
            <div class="container mx-auto px-6 text-center">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    &copy; {{ new Date().getFullYear() }} CMU Cooperative. All Rights Reserved.
                </p>
            </div>
        </footer>

    </div>
</template>

<style scoped>
    /* Custom Nav Item Style */
    .nav-item {
        @apply px-4 py-2 rounded-full text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all flex items-center;
    }
    .nav-item.active {
        @apply text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 font-bold shadow-sm;
    }
    .mobile-link {
        @apply block px-4 py-3 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium;
    }

    /* Space Background */
    .dark .space-bg {
        background-color: #0f172a;
        background-image: 
            radial-gradient(2px 2px at 20px 30px, #eee, rgba(0,0,0,0)),
            radial-gradient(2px 2px at 40px 70px, #fff, rgba(0,0,0,0)),
            radial-gradient(2px 2px at 90px 40px, #fff, rgba(0,0,0,0));
        background-repeat: repeat;
        background-size: 200px 200px;
    }
</style>
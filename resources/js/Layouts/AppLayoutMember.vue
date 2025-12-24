<script setup>
import { Link, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// เหลือแค่ตัวแปรสำหรับเมนูมือถือ
const isMobileMenuOpen = ref(false); 
</script>

<template>
    <Head>
        <component :is="'script'" src="https://cdn.tailwindcss.com"></component>
        <component :is="'script'">
            tailwind.config = { 
                theme: {
                    extend: {
                        fontFamily: { sans: ['Prompt', 'sans-serif'] }
                    }
                }
            }
        </component>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </Head>

    <div class="min-h-screen flex flex-col bg-slate-50 font-sans text-slate-600 transition-colors duration-300">
        
        <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 fixed w-full z-50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    
                    <Link :href="route('landing')" class="flex items-center group">
                        <div class="relative w-12 h-12 mr-3 transition-transform group-hover:scale-110">
                            <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="Logo" class="w-full h-full object-contain drop-shadow-md">
                        </div>
                        <div class="leading-tight">
                            <span class="block font-bold text-lg text-slate-800 tracking-tight">CMUCOOP</span>
                            <span class="block text-[10px] text-blue-600 font-semibold tracking-wider">MEMBER ZONE</span>
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
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="lg:hidden p-2 text-slate-600">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="isMobileMenuOpen" class="lg:hidden bg-white border-t border-slate-200 px-4 py-4 space-y-2 shadow-lg">
                <Link :href="route('member.home')" class="mobile-link">หน้าหลัก</Link>
                <Link :href="route('member')" class="mobile-link">ข้อมูลสมาชิก</Link>
                <Link :href="route('board')" class="mobile-link">สวัสดิการ</Link>
                <Link :href="route('easypoint')" class="mobile-link">EasyPoint</Link>
                <Link :href="route('check.member')" class="mobile-link">ตรวจสอบสมาชิก</Link>
            </div>
        </nav>

        <div class="pt-24 pb-12 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex-grow">
            <slot />
        </div>

        <footer class="bg-white/90 backdrop-blur-md border-t border-slate-200/50 pt-8 pb-6 mt-auto relative z-20 text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-xs text-slate-500">
                    &copy; {{ new Date().getFullYear() }} CMU Cooperative. All Rights Reserved.
                </p>
            </div>
        </footer>

    </div>
</template>

<style scoped>
    .nav-item {
        @apply px-4 py-2 rounded-full text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all flex items-center;
    }
    .nav-item.active {
        @apply text-blue-600 bg-blue-50 font-bold shadow-sm;
    }
    .mobile-link {
        @apply block px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium;
    }
</style>
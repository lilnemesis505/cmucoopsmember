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
           
            <div class="w-full px-6 lg:px-12">
                <div class="flex justify-between items-center h-20">
                    
                    <Link :href="route('landing')" class="flex items-center group no-underline hover:no-underline">
                        <div class="relative w-12 h-12 mr-3 transition-transform group-hover:scale-110">
                        </div>
                        <div class="leading-tight">
                            <span class="block font-bold text-3xl text-blue-600 tracking-tight drop-shadow-[2px_2px_0_rgba(200,200,200,1)] transition-transform duration-300 hover:scale-110 ">Member</span>
                        </div>
                    </Link>

                    <div class="hidden lg:flex items-center space-x-1 ml-auto ">
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
        /* เพิ่ม hover:scale-110 และ transition-all เพื่อให้ขยายแบบนุ่มนวล */
        @apply px-4 py-2 rounded-full text-sm font-medium text-slate-600 
               hover:text-blue-600 hover:bg-blue-50 
               transition-all duration-300 hover:scale-110 
               flex items-center no-underline hover:no-underline;
    }

    .nav-item.active {
        /* เพิ่ม scale-110 ค้างไว้เลย ถ้าหน้านั้นถูกเลือกอยู่ (Active) */
        @apply text-blue-600 bg-blue-50 font-bold shadow-sm 
               underline underline-offset-4 scale-110;
    }

    .mobile-link {
        @apply block px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium;
    }
</style>
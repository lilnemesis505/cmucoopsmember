<script setup>
import { Link, Head } from '@inertiajs/vue3'; // <--- 1. เพิ่ม Head ตรงนี้
</script>

<template>
    <Head>
        <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;600&family=Kanit:wght@300;400;600&family=Kodchasan:wght@300;400;600&family=Mitr:wght@300;400;600&family=Prompt:wght@300;400;600&family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-slate-50 font-sans">
        <nav class="bg-white px-4 md:px-8 py-3 border-b-4 border-purple-400 sticky top-0 z-50 shadow-sm flex justify-between items-center">
            
            <a class="flex items-center gap-3 group no-underline hover:no-underline">
                <div class="relative w-12 h-12 transition-transform group-hover:scale-110">
                    <img src="https://ik.imagekit.io/cmucoopsmember/logo/xcademy.png?updatedAt=1766551989903" alt="CMU Logo" class="w-full h-full object-contain">
                </div>
            </a>
            
            <div class="flex items-center gap-4">
                 <span class="hidden md:inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full border border-purple-200">
                    X-CADEMY
                 </span>
                 <Link :href="route('landing')" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:text-purple-600 transition-all">
                    <i class="bi bi-house-door-fill"></i>
                    <span class="hidden sm:inline">กลับหน้าหลัก</span>
                </Link>
            </div>
        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>

<style>
/* กำหนดฟอนต์หลักของหน้านี้เป็น Prompt หรือ Sarabun ตามชอบ */
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

.font-sans {
    font-family: 'Prompt', sans-serif;
}
</style>
<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-slate-50 font-sans">
        <nav class="bg-white px-4 md:px-8 py-3 border-b-4 border-purple-400 sticky top-0 z-50 shadow-sm flex justify-between items-center">
            
            <a class="flex items-center gap-3 group no-underline hover:no-underline">
                <div class="relative w-12 h-12 transition-transform group-hover:scale-110">
                    <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="CMU Logo" class="w-full h-full object-contain">
                </div>
                <div class="hidden md:block leading-tight ">
                    <span class="block font-bold text-lg text-slate-800 tracking-tight" >CMU X-CADEMY</span>
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

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
    .font-sans { font-family: 'Prompt', sans-serif; }
</style>
<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ page: Object });
</script>

<template>
    <AppLayout>
        <Head :title="page.title" />

        <div class="min-h-screen bg-slate-50 pb-20">
            
            <div class="relative w-full h-[300px] md:h-[380px] bg-white overflow-hidden shadow-sm">
                <img 
                    v-if="page.image_url" 
                    :src="page.image_url" 
                    class="w-full h-full object-cover opacity-30" 
                />
                <div v-else class="w-full h-full bg-gradient-to-b from-white via-pink-50 to-white"></div>
                
                <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-white/20 to-transparent"></div>
                
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10">
                    <h1 class="text-3xl md:text-5xl font-bold text-slate-800 drop-shadow-sm mb-3 tracking-tight">
                        {{ page.title }}
                    </h1>
                    <span v-if="page.subtitle" class="inline-block px-4 py-1 rounded-full bg-pink-100/50 text-pink-700 font-medium text-lg border border-pink-100">
                        {{ page.subtitle }}
                    </span>
                </div>
            </div>

            <div class="max-w-5xl mx-auto px-4 relative z-20 -mt-16">
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 md:p-14 border border-slate-100">
                    
                    <div class="prose prose-lg max-w-none text-slate-600 font-sarabun leading-relaxed" v-html="page.content"></div>

                    <div class="mt-12 pt-10 border-t border-slate-100 text-center">
                        <a href="https://www.cmu-coops.com/login.php" target="_blank" 
                           class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-pink-600 to-rose-500 text-white rounded-full font-bold text-lg shadow-lg shadow-pink-200 hover:shadow-pink-300 hover:scale-105 hover:-translate-y-1 transition-all duration-300"
                        >
                            <span class="bg-white/20 p-1.5 rounded-full group-hover:rotate-45 transition-transform duration-300">
                                <i class="bi bi-box-arrow-up-right text-lg block"></i>
                            </span>
                            <span>เข้าสู่ระบบตรวจสอบข้อมูล</span>
                        </a>
                        <p class="text-slate-400 text-sm mt-3 font-light">
                            <i class="bi bi-shield-lock"></i> คลิกเพื่อเปิดหน้าต่างเข้าสู่ระบบ
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<style>
/* Font & Typo Settings */
.font-sarabun { font-family: 'Sarabun', sans-serif; }

/* จัด Style ของเนื้อหา */
.prose h2 { 
    @apply text-2xl md:text-3xl font-bold text-slate-800 mt-8 mb-4 border-l-4 border-pink-500 pl-4; 
}
.prose h3 {
    @apply text-xl font-bold text-slate-700 mt-6 mb-3;
}
.prose p {
    @apply mb-4 text-slate-600;
}
.prose ul { 
    @apply list-disc list-inside ml-2 space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-100; 
}
.prose strong {
    @apply text-pink-600;
}
</style>
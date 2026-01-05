<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ page: Object });
</script>

<template>
    <AppLayout>
        <Head :title="page.title" />

        <div class="relative w-full h-[300px] md:h-[400px] bg-slate-900 overflow-hidden">
            <img 
                v-if="page.image_url" 
                :src="page.image_url" 
                class="w-full h-full object-cover opacity-60"
            />
            <div v-else class="w-full h-full bg-gradient-to-r from-pink-600 to-purple-800 opacity-90"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4 z-10">
                <h1 class="text-3xl md:text-5xl font-bold text-white drop-shadow-md mb-2">{{ page.title }}</h1>
                <p v-if="page.subtitle" class="text-lg text-pink-100 font-light">{{ page.subtitle }}</p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 py-12">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 min-h-[400px] -mt-20 relative z-20">
                <div class="prose prose-lg max-w-none text-slate-700 font-sarabun" v-html="page.content"></div>

                <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                    <a href="https://www.cmu-coops.com/login.php" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-pink-600 text-white rounded-full font-bold shadow-lg hover:bg-pink-700 hover:scale-105 transition-all">
                        <i class="bi bi-box-arrow-up-right"></i> เข้าสู่ระบบตรวจสอบข้อมูล (ระบบเก่า)
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
/* CSS สำหรับจัดหน้า content ที่มาจาก CKEditor */
.font-sarabun { font-family: 'Sarabun', sans-serif; }
.prose h2 { @apply text-2xl font-bold text-pink-700 mt-6 mb-4; }
.prose ul { @apply list-disc list-inside ml-4 space-y-2; }
</style>
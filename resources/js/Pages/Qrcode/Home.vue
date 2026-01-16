<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ page: Object });
</script>

<template>
    <AppLayout>
        <Head :title="page.title || 'QR Code'" />

        <div class="min-h-screen bg-slate-50 pb-20">
            
            <div class="relative w-full bg-white shadow-sm overflow-hidden group">
                <div v-if="page.image_url" class="w-full md:h-[500px] h-auto">
                     <img 
                        :src="page.image_url" 
                        class="w-full h-full object-contain md:object-cover bg-slate-100" 
                        alt="QR Code Cover"
                    />
                </div>
                <div v-else class="w-full h-[300px] flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                    <i class="bi bi-qr-code-scan text-6xl mb-3"></i>
                </div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-slate-100">
                    
                    <div class="ck-content prose prose-lg prose-slate max-w-none break-words" v-html="page.content"></div>

                    <div v-if="!page.content" class="text-center py-10 text-slate-400">
                        ยังไม่มีรายละเอียดข้อมูล
                    </div>

                </div>
            </div>

        </div>
    </AppLayout>
</template>

<style>
/* จัด Style ให้ Rich Text (CKEditor Content) */
.ck-content img {
    @apply rounded-xl shadow-sm mx-auto my-4 max-w-full h-auto;
}
.ck-content h2 {
    @apply text-2xl font-bold text-slate-800 mt-6 mb-3;
}
.ck-content h3 {
    @apply text-xl font-bold text-slate-700 mt-4 mb-2;
}
.ck-content p {
    @apply mb-4 leading-relaxed text-slate-600;
}
.ck-content ul {
    @apply list-disc list-inside mb-4 pl-4;
}
.ck-content a {
    @apply text-blue-600 hover:text-blue-800 underline;
}
</style>
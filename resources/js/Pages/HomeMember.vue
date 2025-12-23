<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue'; 

defineProps({
    cards: Array,
    title: String
});
</script>

<template>
    <AppLayoutMember>
        <Head :title="title" />

        <div class="max-w-5xl mx-auto">
             
             <div class="text-center mb-10">
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold tracking-wider mb-3">
                    MEMBER SERVICES
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 dark:text-white">
                    ระบบสมาชิกสหกรณ์
                </h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2">เลือกเมนูที่ต้องการใช้งาน</p>
             </div>

             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div v-for="card in cards" :key="card.id" class="group">
                    <Link :href="card.link" class="block h-full">
                        <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:shadow-blue-200/50 dark:hover:shadow-blue-900/20 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col">
                            
                            <div class="h-48 overflow-hidden relative">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10 opacity-60"></div>
                                <img :src="card.image_url" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                
                                <div class="absolute bottom-4 left-4 z-20 w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-blue-600 shadow-md">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>

                            <div class="p-6 flex-grow flex flex-col items-center text-center">
                                <h5 class="text-xl font-bold text-slate-800 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ card.title }}
                                </h5>
                                <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">
                                    {{ card.subtitle }}
                                </p>
                            </div>

                        </div>
                    </Link>
                </div>
            </div>

        </div>

    </AppLayoutMember>
</template>
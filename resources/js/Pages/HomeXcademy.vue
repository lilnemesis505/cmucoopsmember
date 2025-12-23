<script setup>
import { Head, Link } from '@inertiajs/vue3';

// หน้านี้ก็ไม่ใช้ Layout เช่นกัน เพื่อความสวยงาม
</script>

<template>
    <Head title="X-CADEMY - Coming Soon" />

    <div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-4 text-center font-sans relative overflow-hidden">
        
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-orange-100 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-100 rounded-full blur-3xl opacity-40"></div>

        <div class="relative z-10 bg-white p-8 md:p-16 rounded-3xl shadow-xl max-w-lg w-full border border-slate-100">
            
            <div class="w-24 h-24 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm animate-bounce-slow">
                <i class="bi bi-cone-striped text-4xl"></i>
            </div>
            
            <h1 class="text-4xl font-bold text-slate-800 mb-2">X-CADEMY</h1>
            <h2 class="text-lg text-orange-500 font-semibold mb-6 tracking-wide">UNDER CONSTRUCTION</h2>
            
            <p class="text-slate-500 mb-10 leading-relaxed">
                เรากำลังพัฒนาแพลตฟอร์มการเรียนรู้รูปแบบใหม่<br>
                เพื่อสมาชิกสหกรณ์มหาวิทยาลัยเชียงใหม่<br>
                เตรียมพบกับหลักสูตรและกิจกรรมดีๆ เร็วๆ นี้
            </p>

            <Link :href="route('landing')" class="inline-flex items-center justify-center px-8 py-3 bg-slate-100 text-slate-600 rounded-full hover:bg-slate-200 transition-colors font-semibold text-decoration-none">
                <i class="bi bi-arrow-left mr-2"></i> กลับหน้าหลัก
            </Link>
        </div>

        <div class="mt-8 text-slate-400 text-sm">
            CMU COOPERATIVE X-CADEMY PROJECT
        </div>

    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap');
.font-sans { font-family: 'Prompt', sans-serif; }

.animate-bounce-slow { animation: bounce 3s infinite; }
@keyframes bounce {
  0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
  50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
}
</style>
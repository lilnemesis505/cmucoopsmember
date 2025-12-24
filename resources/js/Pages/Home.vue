<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// ฟังก์ชันสำหรับเปิดลิงก์ภายนอก
const openLink = (url) => {
    window.open(url, '_blank');
};
</script>

<template>
    <AppLayout>
        <Head title="หน้าแรก" />

        <div class="relative w-full min-h-[90vh] flex items-center justify-center p-4 md:p-8 overflow-hidden font-sans">
            
            <div class="absolute inset-0 z-0">
                <img src="https://ik.imagekit.io/cmucoopsmember/store.jpg" 
                     alt="Main Background" 
                     class="w-full h-full object-cover">
                
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            </div>

            <div class="relative z-10 w-full h-full max-w-[1600px] mx-auto flex flex-row gap-[2%] gap-y-4 flex-wrap content-center">
                
                <Link :href="route('member.home')" class="card-glass w-[40%] h-[32vh] group bg-gradient-to-br from-blue-600/80 to-indigo-900/80">
                    <div class="flex flex-col items-start justify-between h-full p-6">
                        <i class="bi bi-person-badge-fill text-5xl text-blue-200 group-hover:scale-110 transition-transform"></i>
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-1">MEMBER</h2>
                            <p class="text-blue-100 font-light">ข้อมูลสมาชิก & สวัสดิการ</p>
                        </div>
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="bi bi-arrow-up-right-circle text-2xl text-white"></i>
                        </div>
                    </div>
                </Link>

                <Link :href="route('xcademy')" class="card-glass w-[30%] h-[32vh] group bg-gradient-to-br from-orange-500/80 to-red-900/80">
                    <div class="flex flex-col items-start justify-between h-full p-6">
                        <i class="bi bi-mortarboard-fill text-5xl text-orange-200 group-hover:scale-110 transition-transform"></i>
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-1">X-CADEMY</h2>
                            <p class="text-orange-100 font-light">คอร์สเรียนออนไลน์</p>
                        </div>
                    </div>
                </Link>

                <a href="https://www.cmu-coops.com/" target="_blank" class="card-glass grow h-[32vh] group bg-gradient-to-br from-emerald-600/80 to-teal-900/80">
                    <div class="flex flex-col items-start justify-between h-full p-6">
                        <i class="bi bi-cart4 text-5xl text-emerald-200 group-hover:scale-110 transition-transform"></i>
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-1">STORE</h2>
                            <p class="text-emerald-100 font-light">ช้อปปิ้งออนไลน์</p>
                        </div>
                    </div>
                </a>

                <div class="card-glass w-[24%] h-[32vh] group bg-gradient-to-br from-yellow-500/80 to-amber-700/80 cursor-pointer">
                    <div class="flex flex-col items-center justify-center h-full p-4 text-center">
                        <i class="bi bi-coin text-5xl text-yellow-100 mb-3 group-hover:rotate-12 transition-transform"></i>
                        <h3 class="text-2xl font-bold text-white">Easy Point</h3>
                        <p class="text-yellow-100 text-sm mt-1">แลกคะแนนสะสม</p>
                    </div>
                </div>
                <a href="https://www.cmu-coops.com/login.php" target="_blank" class="card-glass w-[24%] grow-0 h-[32vh] group bg-gradient-to-br from-sky-600/80 to-blue-800/80">
                    <div class="flex flex-col items-center justify-center h-full p-4 text-center">
                        <i class="bi bi-search text-4xl text-sky-100 mb-3 group-hover:scale-110 transition-transform"></i>
                        <h3 class="text-xl font-bold text-white">ตรวจสอบข้อมูล</h3>
                        <p class="text-sky-200 text-sm mt-1">เช็คปันผล/ยอดหนี้</p>
                    </div>
                </a>


            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

.font-sans { 
    font-family: 'Prompt', sans-serif; 
}

/* Base Card Style */
.card-glass {
    @apply relative rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:brightness-110 border border-white/10 backdrop-blur-md;
}

/* Responsive ปรับให้เป็นแนวตั้งถ้าหน้าจอเล็กมาก (มือถือ) */
@media (max-width: 768px) {
    .flex-wrap > div, .flex-wrap > a {
        width: 100% !important; /* เต็มจอในมือถือ */
        height: 200px !important;
        margin-bottom: 1rem;
    }
    .min-h-\[90vh\] {
        min-height: auto;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
}
</style>
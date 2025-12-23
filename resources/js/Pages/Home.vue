<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';

// ข้อมูล Slide
const slides = [
    { 
        id: 0, 
        theme: 'blue', 
        badge: 'ยินดีต้อนรับ', 
        title: 'CMU X-SPACE', 
        desc: 'ศูนย์กลางการเชื่อมต่อสมาชิกสหกรณ์ การเรียนรู้ตลอดชีวิต', 
        btn: 'เข้าสู่ระบบสมาชิก', 
        link: 'member.home', 
        external: false 
    },
    { 
        id: 1, 
        theme: 'orange', 
        badge: 'COMING SOON', 
        title: 'X-CADEMY Learning', 
        desc: 'แพลตฟอร์มการเรียนรู้รูปแบบใหม่ เพื่อพัฒนาศักยภาพของคุณ', 
        btn: 'ดูรายละเอียด', 
        link: 'xcademy', 
        external: false 
    },
    { 
        id: 2, 
        theme: 'green', 
        badge: 'SHOP ONLINE', 
        title: 'Co-op Shop Online', 
        desc: 'เลือกซื้อสินค้าสหกรณ์ โปรโมชั่นพิเศษ และสินค้าแนะนำ', 
        btn: 'ไปที่ร้านค้า', 
        link: 'https://www.cmu-coops.com/', 
        external: true 
    }
];

const currentSlide = ref(0);
let intervalId;

onMounted(() => {
    intervalId = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000);
});

onUnmounted(() => clearInterval(intervalId));
</script>

<template>
    <AppLayout>
        <Head title="ยินดีต้อนรับ - CMU X-SPACE" />

        <div class="relative w-full h-[650px] overflow-hidden bg-slate-50 flex items-center justify-center">
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob"></div>
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-amber-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-32 left-20 w-[600px] h-[600px] bg-emerald-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative z-10 w-full max-w-5xl px-6 text-center mt-[-50px]">
                
                <transition-group name="fade">
                    <div v-for="slide in slides" :key="slide.id" v-show="currentSlide === slide.id" class="absolute inset-0 flex flex-col items-center justify-center">
                        
                        <span :class="`inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-sm mb-6 border
                            ${slide.theme === 'blue' ? 'bg-white text-blue-600 border-blue-100' : 
                              slide.theme === 'orange' ? 'bg-white text-orange-600 border-orange-100' : 
                              'bg-white text-green-600 border-green-100'}`">
                            <i class="bi bi-stars mr-2"></i> {{ slide.badge }}
                        </span>

                        <h1 class="text-5xl md:text-7xl font-extrabold text-slate-800 mb-6 tracking-tight drop-shadow-sm">
                            {{ slide.title }}
                        </h1>
                        
                        <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto font-normal leading-relaxed">
                            {{ slide.desc }}
                        </p>

                        <div class="relative z-50"> 
                            <a v-if="slide.external" :href="slide.link" target="_blank" 
                               class="inline-flex items-center px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full font-bold text-lg shadow-lg hover:shadow-emerald-200/50 transition-all transform hover:-translate-y-1">
                                {{ slide.btn }} <i class="bi bi-box-arrow-up-right ml-2"></i>
                            </a>

                            <Link v-else :href="route(slide.link)" 
                                :class="`inline-flex items-center px-8 py-4 text-white rounded-full font-bold text-lg shadow-lg transition-all transform hover:-translate-y-1
                                ${slide.theme === 'blue' ? 'bg-blue-600 hover:bg-blue-700 hover:shadow-blue-200/50' : 'bg-orange-500 hover:bg-orange-600 hover:shadow-orange-200/50'}`">
                                {{ slide.btn }} <i class="bi bi-arrow-right ml-2"></i>
                            </Link>
                        </div>

                    </div>
                </transition-group>

                <div class="invisible py-32">
                     <h1 class="text-5xl">PLACEHOLDER</h1>
                </div>
            </div>

            <div class="absolute bottom-28 flex space-x-3 z-20">
                <button v-for="slide in slides" :key="'dot-'+slide.id" 
                        @click="currentSlide = slide.id"
                        :class="`h-3 rounded-full transition-all duration-300 shadow-sm ${currentSlide === slide.id ? 'w-10 bg-slate-800' : 'w-3 bg-slate-300 hover:bg-slate-400'}`">
                </button>
            </div>
        </div>

        <div class="relative z-30 -mt-20 pb-24 px-4">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

                <Link :href="route('member.home')" class="group block">
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 hover:-translate-y-2 transition-all duration-300 text-center h-full relative overflow-hidden">
                        <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-4xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">ระบบสมาชิก</h3>
                        <p class="text-slate-500 mb-6">ตรวจสอบข้อมูล เงินปันผล สวัสดิการ</p>
                        <span class="inline-block px-6 py-2 rounded-full border border-blue-200 text-blue-600 font-semibold text-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            เข้าสู่ระบบ
                        </span>
                    </div>
                </Link>

                <Link :href="route('xcademy')" class="group block">
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-orange-100 hover:-translate-y-2 transition-all duration-300 text-center h-full relative overflow-hidden">
                        <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-4xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">X-CADEMY</h3>
                        <p class="text-slate-500 mb-6">แหล่งเรียนรู้และหลักสูตรอบรม</p>
                        <span class="inline-block px-6 py-2 rounded-full border border-orange-200 text-orange-500 font-semibold text-sm group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            ดูหลักสูตร
                        </span>
                    </div>
                </Link>

                <a href="https://www.cmu-coops.com/" target="_blank" class="group block">
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-emerald-100 hover:-translate-y-2 transition-all duration-300 text-center h-full relative overflow-hidden">
                        <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-4xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-bag-heart-fill"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Co-op Shop</h3>
                        <p class="text-slate-500 mb-6">ร้านค้าสหกรณ์ออนไลน์</p>
                        <span class="inline-block px-6 py-2 rounded-full border border-emerald-200 text-emerald-600 font-semibold text-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            ช้อปเลย
                        </span>
                    </div>
                </a>

            </div>
        </div>

    </AppLayout>
</template>

<style scoped>
/* Smooth Fade Transition */
.fade-enter-active, .fade-leave-active { transition: all 0.7s ease; }
.fade-enter-from { opacity: 0; transform: translateY(10px); }
.fade-leave-to { opacity: 0; transform: translateY(-10px); }

/* Animation Utils */
.animate-blob { animation: blob 10s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}
</style>
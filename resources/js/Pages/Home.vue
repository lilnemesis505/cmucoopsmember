<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';

// ข้อมูล Slide (ใส่ route กลับเข้าไป)
const slides = [
    { 
        id: 0, 
        theme: 'blue', 
        title: 'CMU X-SPACE', 
        desc: 'เปิดประสบการณ์ใหม่ เชื่อมต่อทุกความเป็นไปได้ของสมาชิกสหกรณ์', 
        btn: 'เข้าสู่ระบบสมาชิก', 
        link: 'member.home', // ต้องมี route name นี้ใน web.php
        external: false 
    },
    { 
        id: 1, 
        theme: 'orange', 
        title: 'X-CADEMY', 
        desc: 'อัปสกิลของคุณด้วยหลักสูตรออนไลน์ เรียนรู้ได้ทุกที่ ทุกเวลา', 
        btn: 'ดูหลักสูตรทั้งหมด', 
        link: 'xcademy',     // ต้องมี route name นี้ใน web.php
        external: false 
    },
    { 
        id: 2, 
        theme: 'green', 
        title: 'Co-op Shop', 
        desc: 'ช้อปสินค้าคุณภาพ ราคาสมาชิก พร้อมบริการจัดส่งถึงบ้าน', 
        btn: 'เริ่มช้อปปิ้ง', 
        link: 'https://www.cmu-coops.com/', 
        external: true 
    }
];

const currentSlide = ref(0);
let intervalId;

onMounted(() => {
    intervalId = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 6000);
});

onUnmounted(() => clearInterval(intervalId));
</script>

<template>
    <AppLayout>
        <Head title="หน้าแรก" />

        <div class="relative w-full min-h-[600px] lg:h-[750px] overflow-hidden bg-slate-50 flex items-center justify-center pt-10 pb-32">
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-blue-200/40 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob"></div>
                <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-purple-200/40 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-32 left-[20%] w-[50vw] h-[50vw] bg-emerald-100/60 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl px-6 text-center">
                
                <div class="relative h-[300px] flex items-center justify-center">
                    <transition-group name="fade">
                        <div v-for="slide in slides" :key="slide.id" v-show="currentSlide === slide.id" class="absolute inset-0 flex flex-col items-center justify-center">
                            
                            <div class="mb-6 px-4 py-1.5 rounded-full bg-white/60 backdrop-blur border border-white shadow-sm inline-block">
                                <span :class="`text-sm font-bold tracking-wide uppercase 
                                    ${slide.theme === 'blue' ? 'text-blue-600' : slide.theme === 'orange' ? 'text-orange-600' : 'text-emerald-600'}`">
                                    Welcome to {{ slide.title }}
                                </span>
                            </div>

                            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-slate-900 mb-6 tracking-tight leading-tight drop-shadow-sm">
                                {{ slide.title }}
                            </h1>
                            
                            <p class="text-lg md:text-2xl text-slate-600 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                                {{ slide.desc }}
                            </p>

                            <div class="relative z-50 group"> 
                                <a v-if="slide.external" :href="slide.link" target="_blank" 
                                   :class="`cta-button 
                                    ${slide.theme === 'blue' ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200/50' : 
                                      slide.theme === 'orange' ? 'bg-orange-500 hover:bg-orange-600 shadow-orange-200/50' : 
                                      'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200/50'}`">
                                    {{ slide.btn }} 
                                </a>

                                <Link v-else :href="route(slide.link)" 
                                    :class="`cta-button 
                                    ${slide.theme === 'blue' ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200/50' : 
                                      slide.theme === 'orange' ? 'bg-orange-500 hover:bg-orange-600 shadow-orange-200/50' : 
                                      'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200/50'}`">
                                    {{ slide.btn }} 
                                </Link>
                            </div>
                        </div>
                    </transition-group>
                </div>
            </div>

            <div class="absolute bottom-28 md:bottom-20 flex space-x-3 z-20">
                <button v-for="slide in slides" :key="'dot-'+slide.id" 
                        @click="currentSlide = slide.id"
                        :class="`h-2 rounded-full transition-all duration-500 ${currentSlide === slide.id ? 'w-12 bg-slate-800' : 'w-2 bg-slate-300 hover:bg-slate-400'}`">
                </button>
            </div>
        </div>

        <div class="relative z-30 -mt-24 px-4 pb-20">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">

                <Link :href="route('member.home')" class="card-item group">
                    <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div class="text-left md:text-center mt-0 md:mt-4 ml-4 md:ml-0 flex-1">
                        <h3 class="text-xl font-bold text-slate-800">ระบบสมาชิก</h3>
                        <p class="text-sm text-slate-500 mt-1">เช็คสิทธิ์ สวัสดิการ EasyPoint</p>
                    </div>
                    <div class="arrow-icon text-slate-300 group-hover:text-blue-500 md:hidden">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </Link>

                <Link :href="route('xcademy')" class="card-item group">
                    <div class="icon-box bg-orange-50 text-orange-500 group-hover:bg-orange-500 group-hover:text-white">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="text-left md:text-center mt-0 md:mt-4 ml-4 md:ml-0 flex-1">
                        <h3 class="text-xl font-bold text-slate-800">X-CADEMY</h3>
                        <p class="text-sm text-slate-500 mt-1">คอร์สเรียนเพื่อพัฒนาศักยภาพ</p>
                    </div>
                    <div class="arrow-icon text-slate-300 group-hover:text-orange-500 md:hidden">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </Link>

                <a href="https://www.cmu-coops.com/" target="_blank" class="card-item group">
                    <div class="icon-box bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white">
                        <i class="bi bi-bag-heart-fill"></i>
                    </div>
                    <div class="text-left md:text-center mt-0 md:mt-4 ml-4 md:ml-0 flex-1">
                        <h3 class="text-xl font-bold text-slate-800">Co-op Shop</h3>
                        <p class="text-sm text-slate-500 mt-1">สินค้าสหกรณ์ออนไลน์</p>
                    </div>
                    <div class="arrow-icon text-slate-300 group-hover:text-emerald-500 md:hidden">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>

            </div>
        </div>

    </AppLayout>
</template>

<style scoped>
.cta-button {
    @apply inline-flex items-center px-10 py-4 text-white rounded-full font-bold text-lg shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl;
}
.cta-button::after {
    content: "\F138"; 
    font-family: 'bootstrap-icons';
    @apply ml-3 text-sm opacity-70;
}
.card-item {
    @apply flex md:block items-center bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100/50 transition-all duration-300 hover:shadow-2xl hover:shadow-blue-100 hover:-translate-y-2 cursor-pointer relative overflow-hidden;
}
.icon-box {
    @apply w-16 h-16 rounded-2xl flex items-center justify-center text-3xl transition-all duration-300 shadow-sm mx-auto;
}
.fade-enter-active, .fade-leave-active { transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
.fade-enter-from { opacity: 0; transform: translateY(20px) scale(0.95); }
.fade-leave-to { opacity: 0; transform: translateY(-20px) scale(1.05); }
.animate-blob { animation: blob 15s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}
</style>
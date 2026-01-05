<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';

// --- จัดการ Popup ---
const showPopup = ref(true); // เริ่มต้นให้แสดง Popup ทันที

// ใส่ URL ของรูปภาพขนาด 1920x1080 ที่ต้องการตรงนี้
const popupImage = 'https://ik.imagekit.io/cmucoopsmember/%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%99%E0%B8%B2%E0%B8%87.jpg?updatedAt=1767600043418'; 

const enterSite = () => {
    showPopup.value = false;
};
</script>

<template>
    <AppLayout>
        <Head title="หน้าแรก" />

        <Transition
            enter-active-class="transition duration-500 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-700 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0 translate-y-0"
        >
            <div v-if="showPopup" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-black/75 backdrop-blur-sm p-4">
                
                <div class="relative w-full max-w-6xl flex flex-col items-center animate-zoom-in">
                    
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(255,255,255,0.1)] border border-white/10">
                        <img 
                            :src="popupImage" 
                            class="w-full h-full object-cover"
                            alt="Welcome Popup"
                        />
                        
                        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-black/80 to-transparent pointer-events-none"></div>
                    </div>

                    <div class="mt-8 md:-mt-20 relative z-20">
                        <button 
                            @click="enterSite"
                            class="group relative inline-flex items-center gap-3 px-10 py-4 bg-white text-slate-900 rounded-full font-bold text-lg md:text-xl shadow-2xl hover:scale-105 transition-all duration-300 ring-4 ring-white/30 hover:ring-white/50"
                        >
                            <span>เข้าสู่เว็บไซต์</span>
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            
                            <div class="absolute inset-0 rounded-full bg-white blur-lg opacity-40 group-hover:opacity-60 transition-opacity -z-10"></div>
                        </button>
                    </div>

                </div>
            </div>
        </Transition>
        <div class="relative w-full min-h-screen flex flex-col items-center justify-center p-4 md:p-8 font-sans overflow-hidden bg-black">
            
            <div class="absolute inset-0 z-0">
                <img src="https://png.pngtree.com/background/20250207/original/pngtree-soft-pastel-floral-design-light-blue-background-picture-image_16257054.jpg" 
                     alt="Galaxy Background" 
                     class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-b via-slate-900/30"></div>
            </div>

            <div class="absolute inset-0 overflow-hidden pointer-events-none z-1">
                <div class="animated-shape circle shape-1 bg-white/10"></div>
                <div class="animated-shape square shape-2 bg-blue-400/20"></div>
                <div class="animated-shape circle shape-3 bg-purple-400/10"></div>
                <div class="animated-shape square shape-4 bg-cyan-400/20"></div>
                <div class="animated-shape circle shape-5 bg-white/5"></div>
            </div>

            <div class="relative z-10 w-full max-w-[1400px] flex flex-col gap-6 animate-fade-in-down">
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8 mb-2">
                    <div class="bg-white p-1 rounded-xl border-1 border-white">
                         <img
                        src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356"
                        alt="CMU Coop Logo"
                        class="h-19 md:h-20 w-auto"
                    />
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white mb-1 drop-shadow-md mt-3">
                            CMU Coop
                        </h1>
                        <p class="text-lg text-gray-800 tracking-wide font-medium drop-shadow-[0_0_8px_rgba(255,255,255,0.8)]">ศูนย์รวมบริการร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 w-full"> 
                    
                    <Link :href="route('member.home')" class="modern-card md:col-span-7 group border-l-4 border-blue-500">
                        <div class="flex flex-col justify-between h-full p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-cyan-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-125 duration-700 blur-2xl opacity-60"></div>
                            
                            <div class="relative z-10 flex justify-between items-start">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/member3.png?updatedAt=1766716604659" 
                                    alt="Icon"
                                    class="h-19 md:h-24 w-24 object-contain"
                                />
                            </div>
                            <div class="relative z-10 mt-auto pt-8">
                                <h2 class="card-title text-slate-800">MEMBER CONNECT</h2>
                                <p class="card-subtitle text-slate-500">ข้อมูลสมาชิก สวัสดิการ และสิทธิประโยชน์</p>
                                <div class="h-1.5 w-16 bg-blue-500 mt-4 rounded-full group-hover:w-1/2 transition-all duration-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                            </div>
                        </div>
                    </Link>

                    <a href="https://www.cmu-coops.com/" target="_blank" class="modern-card md:col-span-5 group border-l-4 border-cyan-500">
                        <div class="flex flex-col justify-between h-full p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-cyan-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-125 duration-700 blur-2xl opacity-60"></div>
                            <div class="relative z-10 flex justify-between items-start">
                                <img 
                                        src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356" 
                                        alt="Icon"
                                        class="h-19 md:h-24 w-24 object-contain"
                                    />
                            </div>
                            <div class="relative z-10 mt-auto pt-8">
                                <h2 class="card-title text-slate-800">STORE ONLINE</h2>
                                <p class="card-subtitle text-slate-500">ช้อปปิ้งสินค้าสหกรณ์ครบวงจร</p>
                                <div class="h-1.5 w-16 bg-cyan-500 mt-4 rounded-full group-hover:w-1/2 transition-all duration-500 shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
                            </div>
                        </div>
                    </a>

                    <Link :href="route('xcademy')" class="modern-card md:col-span-4 group border-t-4 border-purple-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-purple-200 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
    
                            <div class="relative z-10 mb-4 flex items-center justify-between">
                                <img 
                                        src="https://ik.imagekit.io/cmucoopsmember/logo/xcademy.png?updatedAt=1766551989903" 
                                        alt="Icon"
                                        class="w-25 h-30 object-contain"
                                    />
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">X-CADEMY</h3>
                                <p class="text-sm text-slate-500 mt-1">คอร์สเรียนออนไลน์พัฒนาทักษะ</p>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('member_check.home')" class="modern-card md:col-span-4 group border-t-4 border-pink-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-pink-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 mb-4">
                                <div class="icon-box-sm bg-pink-100 text-pink-600">
                                    <i class="bi bi-shield-check text-2xl"></i>
                                </div>
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">ตรวจสอบข้อมูล สมาชิก</h3>
                                <p class="text-sm text-slate-500 mt-1">เช็คข้อมูลสมาชิก / ยอดหุ้น </p>
                            </div>
                        </div>
                    </Link>

                     <Link :href="route('easypoint')" class="modern-card md:col-span-4 group border-t-4 border-yellow-500 relative z-20">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-yellow-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 mb-4 flex items-center justify-between">
                                    <img 
                                        src="https://ik.imagekit.io/cmucoopsmember/logo/easy1.png?updatedAt=1766638379250" 
                                        alt="Icon"
                                        class="w-25 h-30 object-contain"
                                    />
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">EASY POINT</h3>
                                <p class="text-sm text-slate-500 mt-1">แลกคะแนนสะสมเป็นรางวัล</p>
                            </div>
                        </div>
                    </Link>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

.font-sans { 
    font-family: 'Prompt', sans-serif; 
}

/* === ANIMATION FOR POPUP === */
@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoom-in {
    animation: zoomIn 0.5s ease-out forwards;
}

/* === CARD STYLES === */
.modern-card {
    @apply bg-white rounded-2xl shadow-lg relative transition-all duration-300 ease-out no-underline hover:no-underline flex flex-col;
    /* เปลี่ยนจาก Fixed Height เป็น Min-Height เพื่อความยืดหยุ่น */
    min-height: 240px; 
}

.modern-card:hover {
    @apply -translate-y-2 shadow-[0_10px_40px_rgba(255,255,255,0.2)] z-20; /* เพิ่ม z-index เวลา hover */
}

.icon-box {
    @apply w-14 h-14 rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm;
}
.icon-box-sm {
    @apply w-12 h-12 rounded-lg flex items-center justify-center transition-all duration-300 shadow-sm;
}

.modern-card:hover .icon-box, 
.modern-card:hover .icon-box-sm {
    @apply scale-110 shadow-md;
}

.card-title {
    @apply text-2xl md:text-3xl font-black tracking-tight leading-tight;
}
.card-subtitle {
    @apply text-sm md:text-base font-light mt-2;
}

/* === ANIMATION STYLES === */
.animated-shape {
    position: absolute;
    z-index: 1;
    opacity: 0.5;
    border: 1px solid rgba(255, 255, 255, 0.1);
    animation: float 15s infinite ease-in-out alternate;
}
.animated-shape.circle { border-radius: 50%; }
.animated-shape.square { border-radius: 12px; transform: rotate(45deg); }

@keyframes float {
    0% { transform: translate(0, 0) rotate(0deg); }
    100% { transform: translate(30px, 40px) rotate(10deg); }
}

/* Positions */
.shape-1 { width: 150px; height: 150px; top: 10%; left: 5%; animation-duration: 20s; }
.shape-2 { width: 100px; height: 100px; bottom: 15%; left: 10%; animation-duration: 18s; animation-delay: 2s; }
.shape-3 { width: 200px; height: 200px; top: 20%; right: 5%; animation-duration: 25s; animation-delay: 1s; }
.shape-4 { width: 120px; height: 120px; bottom: 20%; right: 15%; animation-duration: 22s; animation-delay: 3s; }
.shape-5 { width: 80px; height: 80px; top: 40%; left: 45%; animation-duration: 15s; }

.animate-pulse-slow {
    animation: pulse 5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 0.3; }
}

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .grid-cols-1 > * {
        min-height: 200px; /* ลดความสูงในมือถือ */
    }
}
</style>
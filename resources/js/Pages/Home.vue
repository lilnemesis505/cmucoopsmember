<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

const config = ref({
    // 1. รูปพื้นหลัง
    bgImage: 'https://ik.imagekit.io/cmucoopsmember/logo/background.png',
    
    // 2. ความชัดของรูป (0.1 = จางมาก, 1.0 = ชัดสุด)
    bgOpacity: 0.7, 
    
    // 3. สีพื้นหลังหลัก (Hex Code) - ถ้าปรับรูปให้จาง สีนี้จะโผล่ขึ้นมา
    bgColor: '#000000', 
    
    // 4. ความเข้มของเงาดำที่ทับรูป (เพื่อให้อ่านตัวหนังสือง่าย)
    overlayIntensity: 0.3 
});
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
            <div v-if="showPopup" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-/50 backdrop-blur-sm p-4">
            </div>
        </Transition>
        <div class="relative w-full min-h-screen flex flex-col items-center justify-center p-4 md:p-8 font-sans overflow-hidden bg-black">
            
           <div class="absolute inset-0 z-0">
                <img 
                    :src="config.bgImage" 
                    alt="Background" 
                    class="w-full h-full object-cover transition-opacity duration-500"
                    :style="{ opacity: config.bgOpacity }"
                >
                <div 
                    class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-900"
                    :style="{ opacity: config.overlayIntensity }"
                ></div>
            </div>
            <div class="relative z-10 w-full max-w-[1400px] flex flex-col gap-6 animate-fade-in-down">
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8 mb-2">
                    <div class="bg-white p-1 rounded-xl border-1 border-white">
                         <img
                        src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356"
                        alt="CMU Coop Logo"
                        class="h-16 md:h-20 w-auto"
                    />
                    </div>
                   <div class="text-center md:text-left">
    <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white mb-1 drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)] mt-3">
        CMU COOP
    </h1>
    
    <p class="text-lg text-white tracking-wide font-medium drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)]">
        ศูนย์รวมบริการร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด
    </p>
</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 w-full"> 
                    

                    <Link :href="route('member.home')" class="modern-card md:col-span-4 group border-t-4 border-blue-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-blue-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 mb-4 flex items-center justify-between">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/member3.png?updatedAt=1766716604659" 
                                    alt="Icon"
                                    class="w-25 h-20 object-contain group-hover:scale-110 transition-transform"
                                />
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">MEMBER CONNECT</h3>
                                <p class="text-sm text-slate-500 mt-1">ข้อมูลสมาชิก สวัสดิการ</p>
                            </div>
                        </div>
                    </Link>

                    <a href="https://www.cmu-coops.com/" target="_blank" class="modern-card md:col-span-4 group border-t-4 border-cyan-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-cyan-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 flex justify-between items-start">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356" 
                                    alt="Icon"
                                    class="w-25 h-20 object-contain group-hover:scale-110 transition-transform"
                                />
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">STORE ONLINE</h3>
                                <p class="text-sm text-slate-500 mt-1">ช้อปปิ้งสินค้าสหกรณ์ครบวงจร</p>
                            </div>
                        </div>
                    </a>
                     <Link :href="route('check.member')" class="modern-card md:col-span-4 group border-t-4 border-green-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-green-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 mb-4">
                                <div class="icon-box-sm bg-green-100 text-green-600 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-check-circle-fill text-4xl"></i>
                                </div>
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">ตรวจเช็คสมาชิก</h3>
                                <p class="text-sm text-slate-500 mt-1">สำหรับหน่วยงาน และ สถานประกอบการที่รวมรายการ</p>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('member_check.home')" class="modern-card md:col-span-4 group border-t-4 border-pink-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-pink-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
                            <div class="relative z-10 mb-4">
                                <div class="icon-box-sm bg-pink-100 text-pink-600 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-shield-check text-4xl"></i>
                                </div>
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">ตรวจสอบหุ้นและยอดซื้อ</h3>
                                <p class="text-sm text-slate-500 mt-1">ตรวจสอยสมาชิก / ยอดหุ้น </p>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('xcademy')" class="modern-card md:col-span-4 group border-t-4 border-purple-500">
                        <div class="flex flex-col h-full p-6 relative overflow-hidden bg-gradient-to-tr from-white to-purple-100 rounded-xl">
                            <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mr-8 -mt-8 blur-xl opacity-60"></div>
    
                            <div class="relative z-10 mb-4 flex items-center justify-between">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/xcademy.png?updatedAt=1766551989903" 
                                    alt="Icon"
                                    class="w-25 h-20 object-contain group-hover:scale-110 transition-transform"
                                />
                            </div>
                            <div class="relative z-10 mt-auto">
                                <h3 class="text-xl font-bold text-slate-800">X-CADEMY</h3>
                                <p class="text-sm text-slate-500 mt-1">ข่าวสารและกิจกรรม Workshop ประจำเดือน</p>
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
                                    class="w-25 h-20 object-contain group-hover:scale-110 transition-transform"
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

.icon-box-sm {
    @apply w-12 h-12 rounded-lg flex items-center justify-center transition-all duration-300 shadow-sm;
}

.modern-card:hover .icon-box-sm {
    @apply shadow-md;
}


.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
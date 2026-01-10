<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

// --- จัดการ Popup ---
// const showPopup = ref(true);
// const popupImage = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1920&auto=format&fit=crop'; // URL รูป Popup (แก้ไขได้)

// const enterSite = () => {
//     showPopup.value = false;
// };
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
            <div v-if="showPopup" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                
                <div class="relative w-full max-w-4xl flex flex-col items-center animate-zoom-in">
                    
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(255,255,255,0.1)] border border-white/10">
                        <img 
                            :src="popupImage" 
                            class="w-full h-full object-cover"
                            alt="Welcome Popup"
                        />
                        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-black/80 to-transparent pointer-events-none"></div>
                    </div>

                    <div class="mt-8 md:-mt-16 relative z-20">
                        <button 
                            @click="enterSite"
                            class="group relative inline-flex items-center gap-3 px-8 py-3 bg-white text-slate-900 rounded-full font-bold text-lg shadow-2xl hover:scale-105 transition-all duration-300 ring-4 ring-white/30 hover:ring-white/50"
                        >
                            <span>เข้าสู่เว็บไซต์</span>
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>

                </div>
            </div>
        </Transition>
        <div class="relative w-full min-h-screen flex flex-col items-center justify-center p-4 md:p-8 font-sans overflow-hidden bg-black">
            
            <div class="absolute inset-0 z-0">
                <img src="https://ik.imagekit.io/cmucoopsmember/logo/background.png" 
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
                        class="h-16 md:h-20 w-auto"
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
                                <p class="text-sm text-slate-500 mt-1">สำหรับหน่วยงานและสถานประกอบการที่รวมรายการ</p>
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
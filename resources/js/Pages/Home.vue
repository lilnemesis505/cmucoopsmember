<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <Head title="หน้าแรก" />

        <div class="min-h-screen bg-slate-50 font-sans flex flex-col items-center justify-center p-6 md:p-12 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="relative z-10 w-full max-w-6xl flex flex-col gap-10">
                
                <div class="text-center space-y-4 fade-in">
                    <div class="inline-flex items-center justify-center p-3 bg-white rounded-2xl shadow-sm mb-2">
                         <img
                            src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356"
                            alt="CMU Coop Logo"
                            class="h-16 w-auto object-contain"
                        />
                    </div>
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 tracking-tight">
                            CMU Coop
                        </h1>
                        <p class="text-slate-500 mt-2 text-lg font-light">ศูนย์รวมบริการร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 w-full fade-in-up"> 
                    
                    <Link :href="route('member.home')" class="minimal-card lg:col-span-3 group border-b-4 border-blue-500">
                        <div class="card-content">
                            <div class="logo-wrapper bg-blue-50 group-hover:bg-blue-100">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/member3.png?updatedAt=1766716604659" 
                                    alt="Member Icon"
                                    class="h-16 w-auto object-contain"
                                />
                            </div>
                            <div class="text-left mt-4">
                                <h2 class="card-title group-hover:text-blue-600">MEMBER CONNECT</h2>
                                <p class="card-subtitle">ข้อมูลสมาชิก สวัสดิการ และสิทธิประโยชน์</p>
                            </div>
                            <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="bi bi-arrow-right text-2xl text-blue-500"></i>
                            </div>
                        </div>
                    </Link>

                    <a href="https://www.cmu-coops.com/" target="_blank" class="minimal-card lg:col-span-3 group border-b-4 border-cyan-500">
                        <div class="card-content">
                            <div class="logo-wrapper bg-cyan-50 group-hover:bg-cyan-100">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/coop1.png?updatedAt=1766546164356" 
                                    alt="Store Icon"
                                    class="h-16 w-auto object-contain"
                                />
                            </div>
                            <div class="text-left mt-4">
                                <h2 class="card-title group-hover:text-cyan-600">STORE ONLINE</h2>
                                <p class="card-subtitle">ช้อปปิ้งสินค้าสหกรณ์ครบวงจร</p>
                            </div>
                            <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="bi bi-arrow-up-right text-2xl text-cyan-500"></i>
                            </div>
                        </div>
                    </a>

                    <Link :href="route('xcademy')" class="minimal-card lg:col-span-2 group border-b-4 border-purple-500">
                         <div class="card-content h-full">
                            <div class="logo-wrapper bg-purple-50 group-hover:bg-purple-100">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/xcademy.png?updatedAt=1766551989903" 
                                    alt="Xcademy Icon"
                                    class="h-14 w-auto object-contain"
                                />
                            </div>
                            <div class="mt-4">
                                <h3 class="card-title-sm group-hover:text-purple-600">X-CADEMY</h3>
                                <p class="card-subtitle">คอร์สเรียนออนไลน์</p>
                            </div>
                        </div>
                    </Link>

                    <a href="https://www.cmu-coops.com/login.php" target="_blank" class="minimal-card lg:col-span-2 group border-b-4 border-pink-500">
                        <div class="card-content h-full">
                            <div class="logo-wrapper bg-pink-50 group-hover:bg-pink-100 text-pink-500">
                                <i class="bi bi-shield-check text-3xl"></i>
                            </div>
                            <div class="mt-4">
                                <h3 class="card-title-sm group-hover:text-pink-600">ตรวจสอบข้อมูล</h3>
                                <p class="card-subtitle">หุ้น / ปันผล / หนี้สิน</p>
                            </div>
                        </div>
                    </a>

                     <Link :href="route('easypoint')" class="minimal-card lg:col-span-2 group border-b-4 border-yellow-500">
                        <div class="card-content h-full">
                            <div class="logo-wrapper bg-yellow-50 group-hover:bg-yellow-100">
                                <img 
                                    src="https://ik.imagekit.io/cmucoopsmember/logo/easy1.png?updatedAt=1766638379250" 
                                    alt="Easy Point Icon"
                                    class="h-14 w-auto object-contain"
                                />
                            </div>
                            <div class="mt-4">
                                <h3 class="card-title-sm group-hover:text-yellow-600">EASY POINT</h3>
                                <p class="card-subtitle">แลกคะแนนสะสม</p>
                            </div>
                        </div>
                    </Link>

                </div>
                
                <div class="text-center mt-8">
                    <p class="text-slate-400 text-sm">© 2025 CMU Cooperative. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

.font-sans { 
    font-family: 'Prompt', sans-serif; 
}

/* === MINIMAL CARD STYLES === */
.minimal-card {
    @apply bg-white rounded-3xl p-6 relative transition-all duration-300 ease-out flex flex-col justify-between;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02); /* Soft shadow default */
    border: 1px solid #f1f5f9; /* Slate-100 */
}

.minimal-card:hover {
    @apply -translate-y-2;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
}

.card-content {
    @apply flex flex-col items-start h-full;
}

.logo-wrapper {
    @apply w-20 h-20 rounded-2xl flex items-center justify-center transition-colors duration-300;
}

.card-title {
    @apply text-xl md:text-2xl font-bold text-slate-800 tracking-tight transition-colors duration-300;
}

.card-title-sm {
    @apply text-lg md:text-xl font-bold text-slate-800 tracking-tight transition-colors duration-300;
}

.card-subtitle {
    @apply text-slate-400 text-sm mt-1 font-light;
}

/* === UTILS & ANIMATION === */
.fade-in {
    animation: fadeIn 1s ease-out;
}
.fade-in-up {
    animation: fadeInUp 0.8s ease-out both;
    animation-delay: 0.2s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
</style>
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

// ฟังก์ชันดึงช่วงเวลาเพื่อทักทาย (เช้า/บ่าย/เย็น)
const getGreeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'สวัสดีตอนเช้า';
    if (hour < 18) return 'สวัสดีตอนบ่าย';
    return 'สวัสดีตอนเย็น';
};
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />

        <div class="mb-10 relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 text-white p-8 shadow-lg">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="bi bi-grid-3x3-gap-fill text-9xl"></i>
            </div>
            
            <div class="relative z-10">
                <p class="text-orange-400 font-medium mb-1 tracking-wide uppercase text-sm">Admin Control Panel</p>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    {{ getGreeting() }}, ผู้ดูแลระบบ
                </h1>
                <p class="text-slate-400 max-w-xl">
                    ยินดีต้อนรับสู่ระบบจัดการ เลือกเมนูที่คุณต้องการจัดการด้านล่างเพื่อเริ่มต้น
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            
            <Link :href="route('admin.members.index')" class="group relative flex flex-col justify-between h-64 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700 transition-transform duration-700 group-hover:scale-110"></div>
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                
                <div class="absolute -right-6 -bottom-6 text-white/10 transform rotate-12 group-hover:rotate-0 group-hover:scale-110 transition-all duration-700">
                    <i class="bi bi-people-fill text-[10rem]"></i>
                </div>

                <div class="relative z-10 p-8 h-full flex flex-col">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 shadow-inner border border-white/10 group-hover:bg-white group-hover:text-blue-600 transition-colors duration-300">
                        <i class="bi bi-person-vcard-fill text-2xl"></i>
                    </div>
                    
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">ระบบสมาชิก</h2>
                        <p class="text-blue-100 text-sm font-light">Member Management System</p>
                    </div>

                    <div class="mt-auto pt-6 flex items-center text-white/80 text-sm font-medium group-hover:text-white">
                        <span>จัดการข้อมูลสมาชิก & สวัสดิการ</span>
                        <i class="bi bi-arrow-right ml-2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                    </div>
                </div>
            </Link>

            <Link :href="route('admin.events.index')" class="group relative flex flex-col justify-between h-64 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 transition-transform duration-700 group-hover:scale-110"></div>
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                
                <div class="absolute -right-6 -bottom-6 text-white/10 transform rotate-12 group-hover:rotate-0 group-hover:scale-110 transition-all duration-700">
                    <i class="bi bi-mortarboard-fill text-[10rem]"></i>
                </div>

                <div class="relative z-10 p-8 h-full flex flex-col">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 shadow-inner border border-white/10 group-hover:bg-white group-hover:text-orange-600 transition-colors duration-300">
                        <i class="bi bi-calendar-event-fill text-2xl"></i>
                    </div>
                    
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">ระบบ X-CADEMY</h2>
                        <p class="text-orange-100 text-sm font-light">Event & Activity Management</p>
                    </div>

                    <div class="mt-auto pt-6 flex items-center text-white/80 text-sm font-medium group-hover:text-white">
                        <span>จัดการกิจกรรม & อัลบั้มรูป</span>
                        <i class="bi bi-arrow-right ml-2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                    </div>
                </div>
            </Link>

        </div>

        <div class="mt-12">
            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-wider mb-4 px-1">ทางลัดด่วน</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <Link :href="route('landing')" target="_blank" class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:border-blue-500 border border-transparent transition-all group">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <i class="bi bi-globe"></i>
                    </div>
                    <span class="text-slate-700 font-medium text-sm">ดูหน้าเว็บหลัก</span>
                </Link>
                
                <Link :href="route('xcademy')" target="_blank" class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:border-orange-500 border border-transparent transition-all group">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <i class="bi bi-display"></i>
                    </div>
                    <span class="text-slate-700 font-medium text-sm">ดูหน้า X-Cademy</span>
                </Link>
            </div>
        </div>

    </AdminLayout>
</template>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
</style>
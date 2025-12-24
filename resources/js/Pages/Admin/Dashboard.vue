<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">ยินดีต้อนรับ, Admin</h1>
            <p class="text-slate-500">กรุณาเลือกระบบที่ต้องการจัดการ</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mt-10">
            
            <Link :href="route('admin.members.index')" class="group relative bg-white p-8 rounded-2xl shadow-lg border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-bl-full -mr-8 -mt-8 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-people-fill text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">ระบบจัดการสมาชิก</h2>
                    <p class="text-slate-500 text-sm mb-6">จัดการข้อมูลสมาชิก, นำเข้าไฟล์ Excel, ตรวจสอบข้อมูลหุ้น/ปันผล, และข่าวสารสวัสดิการ</p>
                    <span class="px-6 py-2 bg-slate-100 text-slate-600 rounded-full text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors">เข้าสู่ระบบสมาชิก</span>
                </div>
            </Link>

            <Link :href="route('admin.events.index')" class="group relative bg-white p-8 rounded-2xl shadow-lg border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-100 rounded-bl-full -mr-8 -mt-8 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-mortarboard-fill text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">ระบบ X-CADEMY</h2>
                    <p class="text-slate-500 text-sm mb-6">จัดการ Event กิจกรรม, อัปโหลดรูปภาพอัลบั้ม, และแก้ไขรายละเอียดหลักสูตร</p>
                    <span class="px-6 py-2 bg-slate-100 text-slate-600 rounded-full text-sm font-bold group-hover:bg-orange-600 group-hover:text-white transition-colors">เข้าสู่ระบบ X-Cademy</span>
                </div>
            </Link>

        </div>

    </AdminLayout>
</template>
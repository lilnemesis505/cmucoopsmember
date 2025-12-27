<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

// 1. รับค่า Props จาก Laravel
const props = defineProps({
    totalMembers: Number,
    totalEvents: Number
});

// 2. ฟังก์ชันคำนวณคำทักทาย
const getGreeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'สวัสดีตอนเช้า';
    if (hour < 18) return 'สวัสดีตอนบ่าย';
    return 'สวัสดีตอนเย็น';
};
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard Overview" />

        <div class="space-y-8">
            
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ getGreeting() }} คุณ Admin 👋</h2>
                    <p class="text-slate-500 text-sm">ยินดีต้อนรับสู่ระบบจัดการหลังบ้าน CMU Cooperative</p>
                </div>
                <div class="hidden md:flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-600">System Online</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                 <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">{{ totalMembers?.toLocaleString() || 0 }}</h4>
                        <p class="text-xs text-slate-500">สมาชิกทั้งหมด</p>
                    </div>
                 </div>

                 <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">{{ totalEvents?.toLocaleString() || 0 }}</h4>
                        <p class="text-xs text-slate-500">กิจกรรมทั้งหมด</p>
                    </div>
                 </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span> Member Services (แก้ไขเมนูหน้าแรก)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                <i class="bi bi-person-vcard"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">การ์ด: สมาชิก</h3>
                                <p class="text-xs text-slate-500">Member Info</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <Link :href="route('admin.pages.edit', 'member')" class="flex-1 bg-slate-100 text-slate-600 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                                <i class="bi bi-pencil-square"></i> แก้ไขเนื้อหา
                            </Link>
                           <Link :href="route('admin.pages.edit_cover', 'member')" class="flex-1 bg-blue-100 text-blue-600 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-blue-200 transition-colors flex items-center justify-center gap-2">
        <i class="bi bi-image"></i> เปลี่ยนปก
    </Link>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-xl shrink-0">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">การ์ด: สวัสดิการ</h3>
                                <p class="text-xs text-slate-500">Welfare Info</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <Link :href="route('admin.board.index')" class="flex-1 bg-slate-100 text-slate-600 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                                <i class="bi bi-pencil-square"></i> แก้ไขเนื้อหา
                            </Link>
                          <Link :href="route('admin.pages.edit_cover', 'board')" class="flex-1 bg-green-100 text-green-600 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-green-200 transition-colors flex items-center justify-center gap-2">
        <i class="bi bi-image"></i> เปลี่ยนปก
    </Link>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-12 h-12 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl shrink-0">
                                <i class="bi bi-coin"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">การ์ด: Easy Point</h3>
                                <p class="text-xs text-slate-500">Points Info</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <Link :href="route('admin.easypoint.index', 'ezpoint')" class="flex-1 bg-slate-100 text-slate-600 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                                <i class="bi bi-pencil-square"></i> แก้ไขเนื้อหา
                            </Link>
                            <Link :href="route('admin.pages.edit_cover', 'ezpoint')" class="flex-1 bg-yellow-100 text-yellow-700 text-center py-2.5 rounded-lg text-xs font-bold hover:bg-yellow-200 transition-colors flex items-center justify-center gap-2">
        <i class="bi bi-image"></i> เปลี่ยนปก
    </Link>
                        </div>
                    </div>

                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Member Data System
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link :href="route('admin.members.index')" class="shortcut-card group hover:border-green-500/50">
                        <div class="icon-box bg-green-50 text-green-600 group-hover:bg-green-500 group-hover:text-white">
                            <i class="bi bi-people-fill text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">จัดการรายชื่อสมาชิก</h3>
                            <p class="text-xs text-slate-500">ค้นหา, เพิ่ม, ลบ, นำเข้า Excel</p>
                        </div>
                    </Link>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span> X-Cademy System
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link :href="route('admin.events.index')" class="shortcut-card group hover:border-purple-500/50">
                        <div class="icon-box bg-purple-50 text-purple-600 group-hover:bg-purple-500 group-hover:text-white">
                            <i class="bi bi-calendar-event text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">จัดการกิจกรรม (Event)</h3>
                            <p class="text-xs text-slate-500">เพิ่มคอร์ส, Sync รูปภาพ</p>
                        </div>
                    </Link>
                    <Link :href="route('admin.banners.index')" class="shortcut-card group hover:border-purple-500/50">
                        <div class="icon-box bg-purple-50 text-purple-600 group-hover:bg-purple-500 group-hover:text-white">
                            <i class="bi bi-images text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">แบนเนอร์ & สไลด์</h3>
                            <p class="text-xs text-slate-500">รูปหัวเว็บ X-Cademy</p>
                        </div>
                    </Link>
                </div>
            </div>

        </div>
      <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span> Go to Front-End
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <a :href="route('landing')" target="_blank" class="shortcut-card group hover:border-slate-500/50">
                        <div class="icon-box bg-slate-50 text-slate-600 group-hover:bg-slate-500 group-hover:text-white">
                            <i class="bi bi-globe text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">หน้า Landing Page</h3>
                            <p class="text-xs text-slate-500">หน้าแรกเว็บไซต์ (Public)</p>
                        </div>
                    </a>

                    <a :href="route('member.home')" target="_blank" class="shortcut-card group hover:border-blue-500/50">
                        <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-500 group-hover:text-white">
                            <i class="bi bi-house-heart-fill text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">หน้าบ้าน MEMBER</h3>
                            <p class="text-xs text-slate-500">หน้าเมนูหลักสมาชิก</p>
                        </div>
                    </a>

                     <a :href="route('xcademy')" target="_blank" class="shortcut-card group hover:border-purple-500/50">
                        <div class="icon-box bg-purple-50 text-purple-600 group-hover:bg-purple-500 group-hover:text-white">
                            <i class="bi bi-mortarboard-fill text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">หน้าบ้าน X-Cademy</h3>
                            <p class="text-xs text-slate-500">หน้ากิจกรรมและหลักสูตร</p>
                        </div>
                    </a>

                </div>
            </div>
                
    </AdminLayout>
</template>

<style scoped>
.shortcut-card {
    @apply bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4 cursor-pointer;
}
.icon-box {
    @apply w-12 h-12 rounded-lg flex items-center justify-center transition-colors duration-300;
}
</style>
<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth?.user || { name: 'Admin' };
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex font-sans">
        
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full z-20 shadow-xl">
            <div class="h-16 flex items-center justify-center border-b border-slate-700/50 bg-slate-950">
                <span class="text-lg font-bold tracking-wider">CMU COOP <span class="text-blue-500">ADMIN</span></span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                
                <Link :href="route('admin.dashboard')" class="admin-link mb-4" :class="{'active': route().current('admin.dashboard')}">
                    <i class="bi bi-speedometer2 mr-3 text-lg"></i> Dashboard
                </Link>

                <div class="group-header text-blue-400">
                    <i class="bi bi-grid-fill mr-1"></i> MEMBER SERVICES
                </div>
                <Link :href="route('admin.pages.edit', 'member')" class="admin-link" :class="{'active': route().current('admin.pages.edit', 'member')}">
                    <i class="bi bi-person-vcard mr-3"></i> สิทธิประโยชน์สมาชิก
                </Link>
                <Link :href="route('admin.member_check.edit', 'member')" class="admin-link" :class="{'active': route().current('admin.pages.edit', 'member')}">
                    <i class="bi bi-person-vcard mr-3"></i> หน้าตรวจสอบสมาชิก
                </Link>
                <Link :href="route('admin.board.index')" class="admin-link" :class="{'active': route().current('admin.board.*')}">
                    <i class="bi bi-newspaper mr-3"></i> สวัสดิการ (Posts)
                </Link>
                <Link :href="route('admin.easypoint.index', 'ezpoint')" class="admin-link" :class="{'active': route().current('admin.easypoint.*', 'ezpoint')}">
                    <i class="bi bi-coin mr-3"></i> Easy Point
                </Link>

                <div class="group-header text-green-400 mt-4">
                    <i class="bi bi-database mr-1"></i> MEMBER DATA
                </div>
                <Link :href="route('admin.members.index')" class="admin-link" :class="{'active': route().current('admin.members.*')}">
                    <i class="bi bi-people-fill mr-3"></i> จัดการรายชื่อสมาชิก
                </Link>
                <div class="group-header text-purple-400 mt-4">
                    <i class="bi bi-mortarboard mr-1"></i> X-CADEMY
                </div>
                <Link :href="route('admin.events.index')" class="admin-link" :class="{'active': route().current('admin.events.*')}">
                    <i class="bi bi-calendar-event mr-3"></i> กิจกรรม (Events)
                </Link>
                <Link :href="route('admin.banners.index')" class="admin-link" :class="{'active': route().current('admin.banners.*')}">
                    <i class="bi bi-images mr-3"></i> แบนเนอร์ (X-Cademy)
                </Link>

            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <Link :href="route('admin.logout')" method="post" as="button" class="w-full flex items-center justify-center px-4 py-2 bg-red-600/90 hover:bg-red-600 rounded-lg text-sm font-medium transition-all shadow-lg hover:shadow-red-500/20">
                    <i class="bi bi-box-arrow-right mr-2"></i> ออกจากระบบ
                </Link>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8 transition-all">
            <slot />
        </main>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap');
.font-sans { font-family: 'Prompt', sans-serif; }
.group-header {
    @apply px-4 py-2 text-[10px] font-bold uppercase tracking-widest opacity-80 mt-2 mb-1;
}
.admin-link {
    @apply flex items-center px-4 py-2.5 mx-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition-all duration-200 text-sm font-medium;
}
.admin-link.active {
    @apply bg-blue-600 text-white shadow-lg shadow-blue-900/50;
}
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
</style>
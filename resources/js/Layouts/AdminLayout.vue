<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
// ดึงชื่อ user จาก auth (ถ้ามี)
const user = page.props.auth?.user || { name: 'Admin' };
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full z-20">
            <div class="h-16 flex items-center justify-center border-b border-slate-700 shadow-md">
                <span class="text-xl font-bold tracking-wider">CMU COOP <span class="text-orange-500">ADMIN</span></span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <Link :href="route('admin.dashboard')" class="admin-link" :class="{'active': route().current('admin.dashboard')}">
                    <i class="bi bi-grid-fill mr-3"></i> Dashboard
                </Link>

                <div class="text-xs font-bold text-slate-500 mt-6 mb-2 uppercase">Member System</div>
                <Link :href="route('admin.members.index')" class="admin-link">
                    <i class="bi bi-people-fill mr-3"></i> จัดการสมาชิก
                </Link>
                <Link :href="route('admin.board.index')" class="admin-link">
                    <i class="bi bi-clipboard-heart-fill mr-3"></i> สวัสดิการ (Board)
                </Link>
                
                <div class="text-xs font-bold text-slate-500 mt-6 mb-2 uppercase">X-Cademy System</div>
                <Link :href="route('admin.events.index')" class="admin-link">
                    <i class="bi bi-calendar-event-fill mr-3"></i> จัดการ Event
                </Link>
                <Link :href="route('admin.banners.index')" class="admin-link">
                    <i class="bi bi-calendar-event-fill mr-3"></i> จัดการ Event
                </Link>
            </nav>

            <div class="p-4 border-t border-slate-700">
                <Link :href="route('admin.logout')" method="post" as="button" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-sm transition">
                    <i class="bi bi-box-arrow-right mr-2"></i> ออกจากระบบ
                </Link>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.admin-link {
    @apply flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors;
}
.admin-link.active {
    @apply bg-blue-600 text-white shadow-md;
}
</style>
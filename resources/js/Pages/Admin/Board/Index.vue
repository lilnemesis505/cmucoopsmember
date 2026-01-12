<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ posts: Array });

const deletePost = (id) => {
    if(confirm('ยืนยันการลบข้อมูลนี้?')) {
        router.delete(route('admin.board.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="จัดการข่าวสาร/สวัสดิการ" />
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">จัดการข่าวสาร/สวัสดิการ</h2>
            <Link :href="route('admin.board.create')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-bold shadow-sm">
                <i class="bi bi-plus-lg"></i> เพิ่มหัวข้อใหม่
            </Link>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-xs border-b">
                    <tr>
                        <th class="p-4">รูปปก</th>
                        <th class="p-4">หัวข้อ (Title)</th>
                        <th class="p-4">คำโปรย (Subtitle)</th>
                        <th class="p-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <tr v-for="post in posts" :key="post.id" class="hover:bg-slate-50">
                        <td class="p-4 w-24">
                            <img :src="post.cover_image" class="w-16 h-12 object-cover rounded bg-slate-100" />
                        </td>
                        <td class="p-4 font-bold text-slate-700">{{ post.title }}</td>
                        <td class="p-4 text-slate-500 truncate max-w-xs">{{ post.subtitle }}</td>
                        <td class="p-4 text-center space-x-2">
                            <Link :href="route('admin.board.edit', post.id)" class="text-yellow-600 hover:text-yellow-700 bg-yellow-100 p-2 rounded">
                                <i class="bi bi-pencil"></i>
                            </Link>
                            <button @click="deletePost(post.id)" class="text-red-600 hover:text-red-700 bg-red-100 p-2 rounded">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="posts.length === 0">
                        <td colspan="4" class="p-8 text-center text-slate-400">ไม่พบข้อมูล</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
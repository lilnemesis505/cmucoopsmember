<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

const props = defineProps({ 
    page: Object,
    pageKey: String
});

const form = useForm({
    _method: 'PUT',
    title: props.page.title || '',
    subtitle: props.page.subtitle || '',
    content: props.page.content || '',
});

const submit = () => {
    form.put(route('admin.member_check.update', props.pageKey), {
        onSuccess: () => {
            // Success action if needed
        }
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขหน้าตรวจสอบสมาชิก" />

        <component :is="'style'">
            @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&family=Prompt:wght@300;400;600&family=Sarabun:wght@300;400;600&display=swap');
        </component>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 text-sm text-slate-500">
                <Link :href="route('admin.dashboard')" class="hover:text-blue-600">Dashboard</Link>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-slate-800 font-bold">แก้ไขเนื้อหาเพจ</span>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-pink-500"></i> แก้ไข: ตรวจสอบข้อมูลสมาชิก
                </h2>
                
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block font-medium text-slate-700 mb-1">หัวข้อหลัก (Title)</label>
                            <input v-model="form.title" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-200" required />
                        </div>
                        <div class="col-span-2">
                            <label class="block font-medium text-slate-700 mb-1">คำโปรย (Subtitle)</label>
                            <input v-model="form.subtitle" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-200" />
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-slate-700 mb-1">เนื้อหา (Content)</label>
                        <RichTextEditor v-model="form.content" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <Link :href="route('admin.dashboard')" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50">ยกเลิก</Link>
                        
                        <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-bold shadow transition-all flex items-center gap-2">
                            <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                            <i v-else class="bi bi-save"></i> 
                            {{ form.processing ? 'กำลังบันทึก...' : 'บันทึกการแก้ไข' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<style>
/* CKEditor Styles */
.ck-editor__editable {
    min-height: 350px;
    padding: 1rem !important;
}

/* CKEditor Toolbar Radius Fix */
.ck.ck-toolbar {
    border-top-left-radius: 0.5rem !important;
    border-top-right-radius: 0.5rem !important;
    border-color: #cbd5e1 !important;
}
.ck.ck-content {
    border-bottom-left-radius: 0.5rem !important;
    border-bottom-right-radius: 0.5rem !important;
    border-color: #cbd5e1 !important;
}
</style>
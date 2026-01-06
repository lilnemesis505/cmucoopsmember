<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

const form = useForm({
    title: '',
    subtitle: '',
    content: '',
    cover_image: null,
    gallery_images: []
});



const submit = () => {
    form.post(route('admin.board.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="เพิ่มโพสต์ สวัสดิการ" />
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">เพิ่มโพสต์ สวัสดิการ</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">รูปปก (Cover Image)</label>
                    <input type="file" @input="form.cover_image = $event.target.files[0]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อ (Title) <span class="text-red-500">*</span></label>
                        <input v-model="form.title" type="text" class="form-input w-full rounded-md border-slate-300" required />
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">คำโปรย (Subtitle)</label>
                        <input v-model="form.subtitle" type="text" class="form-input w-full rounded-md border-slate-300" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">เนื้อหา (Content)</label>
                    <div class="ck-editor-wrapper">
                        <Ckeditor :editor="editor" v-model="form.content" :config="editorConfig" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">รูปภาพเพิ่มเติม (Gallery)</label>
                    <input type="file" multiple @input="form.gallery_images = $event.target.files" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" accept="image/*" />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <Link :href="route('admin.board.index')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md">
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { ClassicEditor, Essentials, Paragraph, Bold, Italic, Font, List, Link as CkLink, BlockQuote, Heading, Table, TableToolbar, Undo } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

const props = defineProps({ post: Object });

const form = useForm({
    _method: 'PUT',
    title: props.post.title,
    subtitle: props.post.subtitle,
    content: props.post.content,
    cover_image: null,
    gallery_images: [],
    remove_images: []
});

const editor = ClassicEditor;
const editorConfig = {
    licenseKey: 'GPL',
    plugins: [Essentials, Paragraph, Heading, Bold, Italic, Font, List, CkLink, BlockQuote, Table, TableToolbar, Undo],
    toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'fontSize', 'fontColor', '|', 'bulletedList', 'numberedList', '|', 'link', 'insertTable', 'blockQuote'],
};

const currentGallery = ref(props.post.images || []);

const markToRemove = (imgUrl) => {
    form.remove_images.push(imgUrl);
    currentGallery.value = currentGallery.value.filter(img => img !== imgUrl);
};

const submit = () => {
    form.post(route('admin.easypoint.update', props.post.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขโพสต์ Easy Point" />
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">แก้ไข: {{ post.title }}</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
                <div class="flex gap-4 items-start bg-slate-50 p-4 rounded-lg">
                    <div v-if="post.cover_image" class="w-32 h-20 shrink-0">
                        <img :src="post.cover_image" class="w-full h-full object-cover rounded border" />
                        <p class="text-xs text-center text-slate-400 mt-1">รูปปัจจุบัน</p>
                    </div>
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-slate-700 mb-1">เปลี่ยนรูปปก</label>
                        <input type="file" @input="form.cover_image = $event.target.files[0]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-600 file:text-white" accept="image/*" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อ (Title)</label>
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

                <div class="bg-slate-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-slate-700 mb-2">รูปภาพเพิ่มเติม (Gallery)</label>
                    <div v-if="currentGallery.length > 0" class="grid grid-cols-4 md:grid-cols-6 gap-2 mb-4">
                        <div v-for="(img, idx) in currentGallery" :key="idx" class="relative group">
                            <img :src="img" class="w-full h-20 object-cover rounded shadow-sm" />
                            <button type="button" @click="markToRemove(img)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity"><i class="bi bi-x"></i></button>
                        </div>
                    </div>
                    <input type="file" multiple @input="form.gallery_images = $event.target.files" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" accept="image/*" />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <Link :href="route('admin.easypoint.index')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-bold shadow-md">
                        บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
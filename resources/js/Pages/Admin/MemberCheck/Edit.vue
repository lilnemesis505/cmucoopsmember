<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { 
    ClassicEditor, Essentials, Paragraph, Bold, Italic, Font, 
    List, Link as CkLink, BlockQuote, Heading, Table, TableToolbar, Undo 
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

const props = defineProps({ 
    page: Object,
    pageKey: String
});

const form = useForm({
    _method: 'PUT',
    title: props.page.title || '',
    subtitle: props.page.subtitle || '',
    content: props.page.content || '',
    cover_image: null,
    remove_cover: false
});

// CKEditor Config
const editor = ClassicEditor;
const editorConfig = {
    licenseKey: 'GPL',
    plugins: [Essentials, Paragraph, Heading, Bold, Italic, Font, List, CkLink, BlockQuote, Table, TableToolbar, Undo],
    toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'fontSize', 'fontColor', '|', 'bulletedList', 'numberedList', '|', 'link', 'insertTable', 'blockQuote'],
};

// Image Preview
const coverPreview = ref(props.page.image_url || null);
const handleCoverUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        form.remove_cover = false;
        coverPreview.value = URL.createObjectURL(file);
    }
};

const removeCover = () => {
    form.cover_image = null;
    form.remove_cover = true;
    coverPreview.value = null;
};

const submit = () => {
    // ส่งไปที่ Route update โดยส่ง key ไปด้วย
    form.post(route('admin.pages.update', props.pageKey));
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขหน้าตรวจสอบสมาชิก" />

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
                    <div class="flex gap-4 items-start bg-slate-50 p-4 rounded-lg border border-slate-100">
                        <div v-if="coverPreview" class="w-40 h-24 shrink-0 relative group">
                            <img :src="coverPreview" class="w-full h-full object-cover rounded border bg-white" />
                            <button type="button" @click="removeCover" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:scale-110 transition-all">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="flex-grow">
                            <label class="block font-medium text-slate-700 mb-1">รูปปก (Banner)</label>
                            <input type="file" @input="handleCoverUpload" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer" accept="image/*" />
                        </div>
                    </div>

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
                        <div class="ck-editor-wrapper">
                            <Ckeditor :editor="editor" v-model="form.content" :config="editorConfig" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <Link :href="route('admin.dashboard')" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50">ยกเลิก</Link>
                        <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-bold shadow transition-all flex items-center gap-2">
                            <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                            <i v-else class="bi bi-save"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<style>
.ck-editor__editable { min-height: 350px; padding: 1rem !important; }
</style>
<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

// --- 1. Import CKEditor แบบใหม่ (Modular) ---
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { 
    ClassicEditor,
    Essentials, 
    Paragraph, 
    Bold, 
    Italic, 
    Font, 
    List, 
    Link as CkLink, 
    BlockQuote,
    Heading,
    Table, 
    TableToolbar,
    Undo 
} from 'ckeditor5';

// --- 2. Import CSS ของ CKEditor 5 ---
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

// --- 3. ตั้งค่า Editor & Plugins ---
const editor = ClassicEditor;
const editorConfig = {
    licenseKey: 'GPL',
    plugins: [
        Essentials, Paragraph, Heading, Bold, Italic, Font, 
        List, CkLink, BlockQuote, Table, TableToolbar, Undo
    ],
    toolbar: [
        'undo', 'redo', '|', 
        'heading', '|', 
        'bold', 'italic', 'fontSize', 'fontColor', '|',
        'bulletedList', 'numberedList', '|',
        'link', 'insertTable', 'blockQuote'
    ],
    table: {
        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
    }
};

const currentGallery = ref(props.post.images || []);

const markToRemove = (imgUrl) => {
    form.remove_images.push(imgUrl);
    currentGallery.value = currentGallery.value.filter(img => img !== imgUrl);
};

const submit = () => {
    form.post(route('admin.board.update', props.post.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขข่าวสาร" />
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">แก้ไข: {{ post.title }}</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
                <div class="flex gap-4 items-start bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <div v-if="post.cover_image" class="w-32 h-20 shrink-0">
                        <img :src="post.cover_image" class="w-full h-full object-cover rounded border bg-white" />
                        <p class="text-xs text-center text-slate-400 mt-1">รูปปัจจุบัน</p>
                    </div>
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-slate-700 mb-1">เปลี่ยนรูปปก</label>
                        <input type="file" @input="form.cover_image = $event.target.files[0]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer" accept="image/*" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อ (Title)</label>
                        <input v-model="form.title" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">คำโปรย (Subtitle)</label>
                        <input v-model="form.subtitle" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">เนื้อหา (Content)</label>
                    <div class="ck-editor-wrapper">
                        <Ckeditor :editor="editor" v-model="form.content" :config="editorConfig" />
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <label class="block text-sm font-medium text-slate-700 mb-2">รูปภาพเพิ่มเติม (Gallery)</label>
                    
                    <div v-if="currentGallery.length > 0" class="grid grid-cols-4 md:grid-cols-6 gap-2 mb-4">
                        <div v-for="(img, idx) in currentGallery" :key="idx" class="relative group aspect-square">
                            <img :src="img" class="w-full h-full object-cover rounded shadow-sm" />
                            <button type="button" @click="markToRemove(img)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-600">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <input type="file" multiple @input="form.gallery_images = $event.target.files" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer" accept="image/*" />
                    <p class="text-xs text-slate-400 mt-2" v-if="form.remove_images.length > 0">
                        <i class="bi bi-info-circle"></i> กำลังลบ {{ form.remove_images.length }} รูปเมื่อกดบันทึก
                    </p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <Link :href="route('admin.board.index')" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-bold shadow-md transition-colors flex items-center gap-2">
                        <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                        <i v-else class="bi bi-save"></i>
                        บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style>
/* CKEditor Styles */
.ck-editor__editable {
    min-height: 300px;
    padding: 1rem !important;
    font-family: 'Sarabun', sans-serif;
}
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
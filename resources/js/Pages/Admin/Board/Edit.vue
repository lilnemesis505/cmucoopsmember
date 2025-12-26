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

// --- ส่วนจัดการการเลือกรูปภาพเพื่อลบแบบหลายรูป ---
const selectedImages = ref([]); // เก็บ URL ของรูปที่ถูกเลือกอยู่

// เช็คว่ารูปนี้ถูกเลือกอยู่หรือไม่
const isSelected = (imgUrl) => {
    return selectedImages.value.includes(imgUrl);
};

// คลิกเพื่อเลือก/ยกเลิกเลือก
const toggleSelection = (imgUrl) => {
    if (isSelected(imgUrl)) {
        selectedImages.value = selectedImages.value.filter(url => url !== imgUrl);
    } else {
        selectedImages.value.push(imgUrl);
    }
};

// ลบรูปที่เลือกทั้งหมด
const deleteSelectedImages = () => {
    selectedImages.value.forEach(imgUrl => {
        markToRemove(imgUrl);
    });
    selectedImages.value = []; // เคลียร์การเลือกหลังจากลบแล้ว
};
// --------------------------------------------------

const markToRemove = (imgUrl) => {
    // เพิ่มรูปลงใน array remove_images ของฟอร์ม (เช็คกันซ้ำ)
    if (!form.remove_images.includes(imgUrl)) {
        form.remove_images.push(imgUrl);
    }
    // ลบออกจากตัวแปรที่ใช้แสดงผลชั่วคราว
    currentGallery.value = currentGallery.value.filter(img => img !== imgUrl);

    // ถ้าลบรูปเดียวแล้วรูปนั้นถูกเลือกอยู่ด้วย ให้เอาออกจากการเลือก
    if (isSelected(imgUrl)) {
        toggleSelection(imgUrl);
    }
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

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 select-none">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">รูปภาพเพิ่มเติม (Gallery)</label>
                            <p class="text-xs text-slate-500">คลิกที่รูปเพื่อเลือกหลายรายการ</p>
                        </div>
                        
                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                            <button 
                                v-if="selectedImages.length > 0"
                                type="button" 
                                @click="deleteSelectedImages" 
                                class="text-sm text-white font-bold flex items-center gap-2 bg-red-500 hover:bg-red-600 px-4 py-2 rounded-full shadow-sm transition-colors"
                            >
                                <i class="bi bi-trash-fill"></i> ลบ {{ selectedImages.length }} รูปที่เลือก
                            </button>
                        </transition>
                    </div>
                    
                    <div v-if="currentGallery.length > 0" class="grid grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                        <div 
                            v-for="(img, idx) in currentGallery" 
                            :key="idx" 
                            class="relative group aspect-square rounded-lg overflow-hidden cursor-pointer border-2 transition-all duration-200"
                            :class="{'border-red-500 shadow-md': isSelected(img), 'border-transparent hover:border-slate-300': !isSelected(img)}"
                            @click="toggleSelection(img)"
                        >
                            <img :src="img" class="w-full h-full object-cover bg-white transition-opacity" :class="{'opacity-75': isSelected(img)}" />
                            
                            <div class="absolute top-2 left-2 w-6 h-6 rounded-full bg-white/80 flex items-center justify-center border transition-all" :class="{'bg-red-500 border-red-500 text-white': isSelected(img), 'border-slate-300 text-transparent group-hover:border-slate-400': !isSelected(img)}">
                                <i class="bi bi-check-lg text-sm font-bold"></i>
                            </div>

                            <button type="button" @click.stop="markToRemove(img)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-600 hover:scale-110 z-10" title="ลบรูปนี้">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div v-else class="text-center p-8 border-2 border-dashed border-slate-300 rounded-lg text-slate-400 mb-4">
                        ยังไม่มีรูปภาพในแกลเลอรี
                    </div>

                    <div class="flex items-center gap-2">
                         <label class="cursor-pointer bg-white border border-slate-300 hover:border-purple-500 text-slate-600 px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                            <i class="bi bi-cloud-upload-fill text-purple-600"></i> อัปโหลดรูปเพิ่ม...
                            <input type="file" multiple @input="form.gallery_images = $event.target.files" class="hidden" accept="image/*" />
                        </label>
                        <span v-if="form.gallery_images.length > 0" class="text-sm text-purple-600 ml-2">
                             เลือกแล้ว {{ form.gallery_images.length }} ไฟล์
                        </span>
                    </div>

                    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <p class="text-sm text-red-600 mt-3 font-medium flex items-center gap-2 bg-red-50 p-2 rounded-lg border border-red-100" v-if="form.remove_images.length > 0">
                            <i class="bi bi-exclamation-triangle-fill"></i> ระบบจะทำการลบ {{ form.remove_images.length }} รูปภาพอย่างถาวร เมื่อคุณกดปุ่ม "บันทึกการแก้ไข" ด้านล่าง
                        </p>
                    </transition>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <Link :href="route('admin.board.index')" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
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
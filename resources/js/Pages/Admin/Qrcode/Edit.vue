<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import { ref } from 'vue';

const props = defineProps({ 
    page: Object,
    pageKey: String
});

const fileInput = ref(null);

const form = useForm({
    _method: 'PUT',
    title: props.page.title, 
    content: props.page.content || '',
    cover_image: null,
    remove_cover: false // 1. เพิ่มตัวแปรเช็คการลบรูป
});

// Preview รูปภาพ
const coverPreview = ref(props.page.image_url || null);

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        form.remove_cover = false; // ถ้าอัปรูปใหม่ ต้องยกเลิกสถานะการลบ
        coverPreview.value = URL.createObjectURL(file);
    }
};

// 2. เพิ่มฟังก์ชันลบรูป
const removeImage = () => {
    if (confirm('คุณต้องการลบรูปภาพปกนี้ใช่หรือไม่?')) {
        form.remove_cover = true;       // สั่งลบ
        form.cover_image = null;        // เคลียร์ไฟล์ใหม่ (ถ้ามี)
        coverPreview.value = null;      // ลบ Preview ออกจากหน้าจอ
        
        if (fileInput.value) {
            fileInput.value.value = ''; // Reset ช่อง input file
        }
    }
};

const submit = () => {
    form.post(route('admin.pages.update', props.pageKey), {
        onSuccess: () => {
            form.cover_image = null;
            form.remove_cover = false; 
            if (fileInput.value) fileInput.value.value = '';
        }
    });
};
</script>

<template>
    <AdminLayout>
        <Head :title="`จัดการหน้า ${pageKey}`" />

        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <Link :href="route('admin.dashboard')" class="hover:text-blue-600">Dashboard</Link>
                    <i class="bi bi-chevron-right text-xs"></i>
                    <span class="text-slate-800 font-bold">จัดการเนื้อหา ({{ pageKey }})</span>
                </div>
                <a v-if="pageKey === 'qrcode'" :href="route('qrcode')" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <i class="bi bi-eye"></i> ดูหน้าเว็บจริง
                </a>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="bi bi-file-text text-blue-500"></i> รายละเอียด / เนื้อหา
                        </h3>
                        <div class="prose max-w-none">
                            <RichTextEditor v-model="form.content" />
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="bi bi-image text-pink-500"></i> รูปภาพปก / QR Code
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="aspect-square w-full bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg overflow-hidden relative flex items-center justify-center group">
                                <img v-if="coverPreview" :src="coverPreview" class="w-full h-full object-contain bg-white">
                                <div v-else class="text-slate-400 text-center p-4">
                                    <i class="bi bi-upload text-3xl mb-2 block"></i>
                                    <span class="text-xs">ยังไม่มีรูปภาพ</span>
                                </div>

                                <button 
        v-if="coverPreview" 
        type="button"
        @click="removeImage"
        class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-all z-10"
        title="ลบรูปภาพ"
    >
        <i class="bi bi-trash-fill text-lg"></i>
    </button>
                            </div>

                            <input 
                                ref="fileInput"
                                type="file" 
                                @change="handleImageUpload" 
                                accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                            />
                            <p class="text-xs text-slate-400 text-center">รองรับ .jpg, .png, .jpeg</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                         <button 
                            type="submit" 
                            :disabled="form.processing" 
                            class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2"
                        >
                            <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                            <i v-else class="bi bi-save"></i>
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
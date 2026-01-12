<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

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
    cover_image: null,
    upload_images: [],
    remove_images: []
});

// --- ส่วนจัดการ Preview รูปปก ---
const coverPreview = ref(props.page.image_url || null);
const handleCoverUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        coverPreview.value = URL.createObjectURL(file);
    }
};


// --- ส่วนจัดการรูปภาพ Gallery ---
const currentImages = ref(props.page.images || []);
const markToRemove = (imgUrl) => {
    form.remove_images.push(imgUrl);
    currentImages.value = currentImages.value.filter(img => img !== imgUrl);
};

const submit = () => {
    form.post(route('admin.pages.update', props.pageKey), {
        onSuccess: () => {
            form.upload_images = []; 
            form.remove_images = [];
            form.cover_image = null;
        }
    });
};

const getPageName = (key) => {
    const names = {
        'member': 'สิทธิประโยชน์สมาชิก (Member)',
        'board': 'สวัสดิการ (Welfare)',
        'ezpoint': 'Easy Point'
    };
    return names[key] || key;
};
</script>

<template>
    <AdminLayout>
        <Head :title="'แก้ไข: ' + pageKey" />

        <component :is="'style'">
            @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&family=Prompt:wght@300;400;600&family=Sarabun:wght@300;400;600&display=swap');
        </component>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 text-sm text-slate-500">
                <Link :href="route('admin.dashboard')" class="hover:text-blue-600">Dashboard</Link>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-slate-800 font-bold">แก้ไขเนื้อหา</span>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">แก้ไข: {{ getPageName(pageKey) }}</h2>
                        <p class="text-xs text-slate-500">ปรับปรุงข้อมูลที่แสดงหน้าเว็บไซต์</p>
                    </div>
                </div>
                
                <form @submit.prevent="submit" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อหลัก (Title)</label>
                            <input v-model="form.title" type="text" class="form-input w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">คำโปรย (Subtitle)</label>
                            <input v-model="form.subtitle" type="text" class="form-input w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            รายละเอียดเนื้อหา (Content)
                        </label>
                        <RichTextEditor v-model="form.content" />
                    </div>

                    <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                        <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="bi bi-images"></i> จัดการรูปภาพประกอบ (Gallery)
                        </h3>
                        
                        <div v-if="currentImages.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div v-for="(img, idx) in currentImages" :key="idx" class="group relative aspect-video bg-white rounded-lg overflow-hidden shadow-sm border border-slate-200">
                                <img :src="img" class="w-full h-full object-cover" />
                                <button type="button" @click="markToRemove(img)" class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-transform hover:scale-110" title="ลบรูปนี้">
                                    <i class="bi bi-trash-fill text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div v-else class="text-center py-4 text-slate-400 text-sm italic border-2 border-dashed border-slate-200 rounded-lg mb-4">
                            ยังไม่มีรูปภาพประกอบ
                        </div>

                        <div class="flex items-center gap-4">
                            <label class="cursor-pointer bg-white border border-slate-300 hover:border-blue-500 hover:text-blue-600 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                                <i class="bi bi-cloud-upload"></i> อัปโหลดรูปเพิ่ม...
                                <input type="file" multiple @input="form.upload_images = $event.target.files" class="hidden" accept="image/*" />
                            </label>
                            <span v-if="form.upload_images.length" class="text-sm text-green-600 font-medium animate-pulse">
                                เลือกแล้ว {{ form.upload_images.length }} ไฟล์
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <Link :href="route('admin.dashboard')" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 font-medium transition-colors">
                            ยกเลิก
                        </Link>
                        <button type="submit" :disabled="form.processing" class="px-8 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
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
.ck-editor__editable {
    min-height: 350px;
    padding: 1rem !important;
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
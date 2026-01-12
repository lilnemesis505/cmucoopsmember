<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    event: Object,
    images: Array,
    key_param: String // รับชื่อ key มา (เช่น ev1)
});

// Form 1: แก้ไขรายละเอียด
const formDetails = useForm({
    event_title: props.event.title || '',
    event_date: props.event.event_date || '',
    event_description: props.event.description || ''
});

// Form 2: อัปโหลดรูป
const formUpload = useForm({
    event_image: null
});

// Submit รายละเอียด
const submitDetails = () => {
    formDetails.post(route('admin.events.update_details', props.key_param), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', timer: 1500, showConfirmButton: false });
        }
    });
};

// Submit อัปโหลดรูป
const submitUpload = () => {
    if (!formUpload.event_image) return;
    formUpload.post(route('admin.events.upload', props.key_param), {
        preserveScroll: true,
        onSuccess: () => {
            formUpload.reset();
            Swal.fire({ icon: 'success', title: 'อัปโหลดสำเร็จ', timer: 1500, showConfirmButton: false });
        }
    });
};

// ลบรูปภาพ
const deleteImage = (id) => {
    Swal.fire({
        title: 'ลบรูปภาพ?',
        text: "คุณต้องการลบรูปภาพนี้ใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ลบเลย'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.events.delete_image', id), {
                preserveScroll: true
            });
        }
    });
};

// ลบกิจกรรมทั้งหมด (Danger Zone)
const deleteEvent = () => {
    Swal.fire({
        title: `ลบกิจกรรม ${props.key_param}?`,
        text: "การกระทำนี้ไม่สามารถเรียกคืนได้ ข้อมูลทั้งหมดจะหายไป",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ยืนยันลบ'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.events.destroy', props.key_param));
        }
    });
};
</script>

<template>
    <AdminLayout>
        <Head :title="`แก้ไข ${key_param}`" />

        <div class="mb-6">
            <Link :href="route('admin.events.index')" class="text-slate-500 hover:text-blue-600 text-sm flex items-center gap-1 mb-2">
                <i class="bi bi-arrow-left"></i> กลับหน้ารวม
            </Link>
            <h1 class="text-2xl font-bold text-slate-800">
                จัดการ Event: <span class="text-blue-600 uppercase">{{ key_param }}</span>
            </h1>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <div class="xl:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-blue-500"></i> แก้ไขรายละเอียด
                    </h3>
                    <form @submit.prevent="submitDetails" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อ</label>
                            <input v-model="formDetails.event_title" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="ชื่อกิจกรรม...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">วันที่จัดกิจกรรม</label>
                            <input v-model="formDetails.event_date" type="date" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">รายละเอียด</label>
                            <textarea v-model="formDetails.event_description" rows="5" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="รายละเอียดเนื้อหา..."></textarea>
                        </div>
                        <button type="submit" :disabled="formDetails.processing" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-cloud-upload text-green-500"></i> อัปโหลดรูปภาพ
                    </h3>
                    <form @submit.prevent="submitUpload" class="flex items-start gap-4">
                        <div class="flex-1">
                            <input type="file" @input="formUpload.event_image = $event.target.files[0]" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                            <p class="text-xs text-slate-400 mt-1">* รองรับไฟล์ jpg, png, jpeg</p>
                        </div>
                        <button type="submit" :disabled="formUpload.processing || !formUpload.event_image" class="bg-slate-800 hover:bg-black text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            อัปโหลด
                        </button>
                    </form>
                    <div v-if="formUpload.progress" class="w-full bg-gray-200 rounded-full h-1.5 mt-3">
                        <div class="bg-blue-600 h-1.5 rounded-full" :style="{ width: formUpload.progress.percentage + '%' }"></div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-700 text-sm"><i class="bi bi-images"></i> รูปภาพ ({{ images.length }})</h3>
                    </div>
                    
                    <div class="max-h-[500px] overflow-y-auto p-2">
                        <div v-if="images.length === 0" class="text-center py-8 text-slate-400 text-sm">
                            ยังไม่มีรูปภาพ
                        </div>
                        <div v-else class="space-y-2">
                            <div v-for="img in images" :key="img.id" class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-lg border border-transparent hover:border-slate-100 transition-all">
                                <img :src="img.image_url" class="w-16 h-12 object-cover rounded border border-slate-200">
                                <div class="flex-1 min-w-0">
                                    <a :href="img.image_url" target="_blank" class="text-xs text-blue-500 truncate block hover:underline">{{ img.image_url }}</a>
                                </div>
                                <button @click="deleteImage(img.id)" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition-colors">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-xl border border-red-100 p-6">
                    <h4 class="text-red-800 font-bold text-sm mb-2">ลบกิจกรรมนี้</h4>
                    <p class="text-red-600/80 text-xs mb-4">
                        ระบบจะทำการลบข้อมูลของ <strong>{{ key_param }}</strong> ทั้งหมด (หัวข้อ, รายละเอียด, รูปภาพ) การกระทำนี้ไม่สามารถกู้คืนได้
                    </p>
                    <button @click="deleteEvent" class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white py-2 rounded-lg text-sm font-bold transition-colors">
                        <i class="bi bi-trash me-1"></i> ยืนยันการลบ
                    </button>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
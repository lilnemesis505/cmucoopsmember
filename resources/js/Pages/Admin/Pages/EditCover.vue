<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({ 
    page: Object,
    pageKey: String
});

const form = useForm({
    _method: 'PUT',
    cover_image: null
});

// Preview Logic
const coverPreview = ref(props.page.image_url || null);

const handleCoverUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        coverPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (!form.cover_image) return alert('กรุณาเลือกรูปภาพก่อนบันทึก');
    form.post(route('admin.pages.update_cover', props.pageKey), {
        onSuccess: () => {
            form.cover_image = null;
            // ไม่ต้อง reset preview เพื่อให้เห็นรูปใหม่ที่เพิ่งอัป
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
        <Head :title="'จัดการรูปปก: ' + pageKey" />

        <div class="max-w-2xl mx-auto">
            <div class="flex items-center gap-2 mb-6 text-sm text-slate-500">
                <Link :href="route('admin.dashboard')" class="hover:text-blue-600">Dashboard</Link>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-slate-800 font-bold">จัดการรูปปก</span>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-500 text-white flex items-center justify-center text-xl shadow-sm">
                        <i class="bi bi-image"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">{{ getPageName(pageKey) }}</h2>
                        <p class="text-xs text-slate-500">เปลี่ยนรูปภาพปกของการ์ด</p>
                    </div>
                </div>
                
                <div class="p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">ตัวอย่างรูปปกปัจจุบัน</label>
                            <div class="w-full aspect-[4/3] bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden relative group">
                                <img v-if="coverPreview" :src="coverPreview" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                <div v-else class="text-slate-400 flex flex-col items-center">
                                    <i class="bi bi-image text-4xl mb-2"></i>
                                    <span>ยังไม่มีรูปปก</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">เลือกรูปภาพใหม่</label>
                            <input 
                                type="file" 
                                @change="handleCoverUpload" 
                                accept="image/*"
                                class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                cursor-pointer border border-slate-300 rounded-full bg-white transition-all"
                            />
                            <p class="text-xs text-slate-400 mt-2">
                                <i class="bi bi-info-circle"></i> แนะนำขนาด 800x600px หรืออัตราส่วน 4:3 (.jpg, .png)
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <Link :href="route('admin.dashboard')" class="flex-1 py-2.5 text-center text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 font-medium transition-colors">
                                กลับหน้าหลัก
                            </Link>
                            <button type="submit" :disabled="form.processing || !form.cover_image" class="flex-[2] py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                                <i v-else class="bi bi-check-lg"></i>
                                บันทึกรูปปกใหม่
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
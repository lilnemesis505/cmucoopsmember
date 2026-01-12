<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

// รับข้อมูลจาก Controller
const props = defineProps({
    sliders: Array,
    staticBanner: Object
});

// --- Form สำหรับ Slider ---
const sliderForm = useForm({
    image: null,
});

const sliderInput = ref(null);

const submitSlider = () => {
    if (!sliderForm.image) return;
    
    sliderForm.post(route('admin.banners.slider.store'), {
        preserveScroll: true,
        onSuccess: () => {
            sliderForm.reset();
            if (sliderInput.value) sliderInput.value.value = null; // Clear input file
        },
    });
};

// --- ฟังก์ชันลบ Banner ---
const deleteBanner = (id, type) => {
    let message = 'ยืนยันการลบรูปภาพนี้?';
    
    if (type === 'static') {
        message = '⚠️ คุณต้องการลบ "รูปโปสเตอร์ขวา" ออกใช่หรือไม่?';
    } else {
        message = '⚠️ คุณต้องการลบ "รูปสไลด์" นี้ใช่หรือไม่?';
    }

    if (confirm(message)) {
        useForm({}).delete(route('admin.banners.destroy', id));
    }
};

// --- Form สำหรับ Static Banner ---
const staticForm = useForm({
    image: null,
});

const staticInput = ref(null);

const submitStatic = () => {
    if (!staticForm.image) return;

    staticForm.post(route('admin.banners.static.update'), {
        preserveScroll: true,
        onSuccess: () => {
            staticForm.reset();
            if (staticInput.value) staticInput.value.value = null;
        },
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="จัดการ Banner & Slide" />

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">จัดการหน้าหลัก (Banner & Slide)</h1>
            <Link :href="route('admin.dashboard')" class="text-slate-500 hover:text-slate-700">
                <i class="bi bi-arrow-left"></i> กลับ Dashboard
            </Link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="mb-4 border-b pb-2 flex justify-between items-end">
                    <div>
                        <h2 class="text-lg font-bold text-purple-600">
                            <i class="bi bi-images mr-2"></i>ภาพสไลด์
                        </h2>
                        <p class="text-xs text-slate-400">ขนาดแนะนำ: แนวนอน 16:9 (1920 x 1080)</p>
                    </div>
                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">
                        {{ sliders.length }} รูปภาพ
                    </span>
                </div>

                <form @submit.prevent="submitSlider" class="mb-6 bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                    <label class="block mb-2 text-sm font-medium text-slate-700">เพิ่มรูปสไลด์ใหม่</label>
                    <div class="flex gap-2">
                        <input 
                            type="file" 
                            ref="sliderInput"
                            @input="sliderForm.image = $event.target.files[0]"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all"
                            accept="image/*"
                        />
                        <button 
                            type="submit" 
                            :disabled="sliderForm.processing || !sliderForm.image"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm whitespace-nowrap"
                        >
                            <span v-if="sliderForm.processing"><i class="bi bi-arrow-repeat animate-spin"></i></span>
                            <span v-else><i class="bi bi-upload mr-1"></i> อัปโหลด</span>
                        </button>
                    </div>
                    <div v-if="sliderForm.errors.image" class="text-red-500 text-xs mt-1">{{ sliderForm.errors.image }}</div>
                </form>

                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    <div v-if="sliders.length === 0" class="text-center py-10 text-slate-400 italic bg-slate-50 rounded-lg">
                        ยังไม่มีรูปภาพสไลด์
                    </div>
                    
                    <div v-for="slide in sliders" :key="slide.id" class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                        <div class="relative w-full aspect-video bg-slate-100">
                             <img :src="slide.image_url" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-3 flex justify-between items-center bg-slate-50 border-t border-slate-100">
                            <span class="text-xs text-slate-400">
                                <i class="bi bi-calendar"></i> {{ new Date(slide.created_at).toLocaleDateString('th-TH') }}
                            </span>
                            <div class="flex gap-2">
                                <a :href="slide.image_url" target="_blank" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-600 text-xs rounded hover:bg-slate-50 transition-colors">
                                    <i class="bi bi-eye"></i> ดูรูป
                                </a>
                                <button @click="deleteBanner(slide.id, 'slider')" class="px-3 py-1.5 bg-red-100 text-red-600 border border-red-200 text-xs rounded font-bold hover:bg-red-200 transition-colors flex items-center gap-1">
                                    <i class="bi bi-trash"></i> ลบรูปนี้
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 h-fit">
                <div class="mb-4 border-b pb-2">
                    <h2 class="text-lg font-bold text-blue-600">
                        <i class="bi bi-card-image mr-2"></i>รูปโปสเตอร์ขวา
                    </h2>
                    <p class="text-xs text-slate-400">ขนาดแนะนำ: แนวตั้งหรือจัตุรัส (แสดงผลเพียง 1 รูป)</p>
                </div>

                <div class="mb-4 w-full aspect-[4/3] bg-slate-100 rounded-xl overflow-hidden border border-slate-200 relative">
                    <img v-if="staticBanner" :src="staticBanner.image_url" class="w-full h-full object-cover">
                    <div v-else class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                        <i class="bi bi-image text-4xl mb-2"></i>
                        <span>ยังไม่มีรูปภาพ</span>
                    </div>
                </div>

                <div v-if="staticBanner" class="mb-6">
                    <button @click="deleteBanner(staticBanner.id, 'static')" class="w-full py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                        <i class="bi bi-trash-fill"></i> ลบรูปโปสเตอร์ปัจจุบันออก
                    </button>
                </div>

                <form @submit.prevent="submitStatic" class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                    <label class="block mb-2 text-sm font-medium text-slate-700">เปลี่ยน/อัปโหลด รูปภาพใหม่</label>
                    <div class="flex flex-col gap-3">
                        <input 
                            type="file" 
                            ref="staticInput"
                            @input="staticForm.image = $event.target.files[0]"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all"
                            accept="image/*"
                        />
                        <button 
                            type="submit" 
                            :disabled="staticForm.processing || !staticForm.image"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm"
                        >
                            <span v-if="staticForm.processing"><i class="bi bi-arrow-repeat animate-spin"></i> กำลังอัปโหลด...</span>
                            <span v-else><i class="bi bi-arrow-clockwise mr-1"></i> อัปเดตรูปภาพ</span>
                        </button>
                    </div>
                    <div v-if="staticForm.errors.image" class="text-red-500 text-xs mt-1">{{ staticForm.errors.image }}</div>
                </form>
            </div>

        </div>
    </AdminLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
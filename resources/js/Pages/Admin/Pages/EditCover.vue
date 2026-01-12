<script setup>
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({ 
    page: Object,
    pageKey: String
});

const form = useForm({
    _method: 'PUT',
    title: props.page.title || '',
    subtitle: props.page.subtitle || '',
    cover_image: null
});

// Preview Logic
const coverPreview = ref(props.page.image_url || null);

// --- ระบบแจ้งเตือน (Notification) ---
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref('success'); // 'success' หรือ 'error'

const triggerToast = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;
    
    // ซ่อนอัตโนมัติเมื่อผ่านไป 3 วินาที
    setTimeout(() => {
        showToast.value = false;
    }, 3000);
};
// ----------------------------------

const handleCoverUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        coverPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('admin.pages.update_cover', props.pageKey), {
        onSuccess: () => {
            // เช็คว่า Backend ส่ง Flash Message อะไรมาไหม (ถ้ามี error จาก catch)
            const page = usePage();
            if (page.props.flash?.error) {
                triggerToast(page.props.flash.error, 'error');
            } else {
                triggerToast('บันทึกข้อมูลเรียบร้อยแล้ว!', 'success');
                form.cover_image = null;
            }
        },
        onError: (errors) => {
            // กรณี Validate ไม่ผ่าน
            triggerToast('เกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูล', 'error');
            console.error(errors);
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

        <Transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showToast" class="fixed top-5 right-5 z-50 max-w-sm w-full shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4" :class="toastType === 'success' ? 'bg-white border-l-4 border-green-500' : 'bg-white border-l-4 border-red-500'">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i v-if="toastType === 'success'" class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                            <i v-else class="bi bi-x-circle-fill text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-slate-900">
                                {{ toastType === 'success' ? 'สำเร็จ!' : 'ข้อผิดพลาด!' }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ toastMessage }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="showToast = false" class="bg-white rounded-md inline-flex text-slate-400 hover:text-slate-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <i class="bi bi-x text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
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
                        <p class="text-xs text-slate-500">แก้ไขข้อมูลการ์ดและรูปภาพปก</p>
                    </div>
                </div>
                
                <div class="p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div class="grid grid-cols-1 gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อการ์ด (Title)</label>
                                <input 
                                    v-model="form.title" 
                                    type="text" 
                                    class="w-full text-sm border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="เช่น สวัสดิการ"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">คำโปรยสั้นๆ (Subtitle)</label>
                                <input 
                                    v-model="form.subtitle" 
                                    type="text" 
                                    class="w-full text-sm border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="เช่น รายละเอียดสวัสดิการต่างๆ"
                                />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">รูปปกปัจจุบัน</label>
                            <div class="w-full aspect-[4/3] bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden relative group">
                                <img v-if="coverPreview" :src="coverPreview" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                <div v-else class="text-slate-400 flex flex-col items-center">
                                    <i class="bi bi-image text-4xl mb-2"></i>
                                    <span>ยังไม่มีรูปปก</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน)</label>
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
                            <button type="submit" :disabled="form.processing" class="flex-[2] py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                                <i v-else class="bi bi-check-lg"></i>
                                บันทึกข้อมูล
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
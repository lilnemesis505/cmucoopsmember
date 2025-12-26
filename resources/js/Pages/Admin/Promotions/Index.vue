<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ promotions: Array });

// แปลง array ของโปรโมชั่นให้อยู่ในรูปแบบที่ Form จัดการง่าย
const form = useForm({
    promotions: props.promotions.reduce((acc, promo) => {
        acc[promo.id] = {
            main_title: promo.main_title,
            subtitle: promo.subtitle,
            image: null // สำหรับเก็บไฟล์ใหม่
        };
        return acc;
    }, {})
});

const handleFileUpload = (id, event) => {
    form.promotions[id].image = event.target.files[0];
};

const submit = () => {
    // ใช้ _method: PUT ไม่ได้กับการส่งไฟล์หลายไฟล์แบบ nested ใน Inertia v1 บางที 
    // ดังนั้นเราใช้ POST ไปที่ Route updateAll โดย Controller ต้องรับ Request
    // หมายเหตุ: Controller ของคุณเขียนรับ Request แบบปกติไว้แล้ว 
    form.post(route('admin.promotions.update_all'));
};
</script>

<template>
    <AdminLayout>
        <Head title="จัดการโปรโมชั่น" />
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">จัดการโปรโมชั่นหน้าแรก</h2>
            <button @click="submit" :disabled="form.processing" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-bold shadow-md">
                <span v-if="form.processing"><i class="bi bi-hourglass-split"></i> กำลังบันทึก...</span>
                <span v-else><i class="bi bi-save"></i> บันทึกทั้งหมด</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="promo in promotions" :key="promo.id" class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="mb-4 relative h-40 bg-slate-100 rounded-lg overflow-hidden group">
                    <img :src="promo.image_url" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <label class="cursor-pointer bg-white text-slate-800 px-3 py-1 rounded text-sm font-bold shadow">
                            เปลี่ยนรูป
                            <input type="file" class="hidden" @change="handleFileUpload(promo.id, $event)" accept="image/*" />
                        </label>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">หัวข้อหลัก</label>
                        <input v-model="form.promotions[promo.id].main_title" class="w-full border-slate-200 rounded text-sm" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">คำโปรยรอง</label>
                        <input v-model="form.promotions[promo.id].subtitle" class="w-full border-slate-200 rounded text-sm" />
                    </div>
                </div>
                <div v-if="form.promotions[promo.id].image" class="mt-2 text-xs text-green-600 font-bold">
                    * รอการอัปโหลดรูปใหม่
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
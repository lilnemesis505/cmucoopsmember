<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    events: Array
});

// ฟังก์ชันสำหรับ Sync รูปภาพ
const syncImages = () => {
    Swal.fire({
        title: 'ยืนยันการ Sync?',
        text: "ระบบจะทยอยดึงรูปจาก Clound server เข้ามาในระบบ กรุณาเปิดหน้านี้ค้างไว้",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'เริ่มการ Sync',
        confirmButtonColor: '#3b82f6',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            
            // ตัวแปรสำหรับลูป
            let batchSize = 5;    // เช็คทีละ 5 โฟลเดอร์ (เร็วและชัวร์)
            let maxCheck = 100;   // เช็คสูงสุดถึง ev100
            let currentStart = 1;
            
            // ตัวแปรเก็บสถิติรวม
            let totalCreated = 0;
            let totalSynced = 0;
            let totalSkipped = 0;
            let consecutiveEmptyBatches = 0; // ไว้นับว่าถ้าว่างติดกันหลายรอบให้หยุด

            // 1. แสดง Popup เริ่มต้น
            Swal.fire({
                title: 'กำลังเริ่มต้น...',
                html: 'เตรียมการเชื่อมต่อ ImageKit',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                // 2. เริ่มวนลูปยิง Request (Client-side Loop)
                while (currentStart <= maxCheck) {
                    let currentEnd = currentStart + batchSize - 1;
                    
                    // อัปเดตข้อความให้ User รู้ว่ากำลังทำอะไรอยู่
                    Swal.update({
                        title: `กำลังประมวลผล...`,
                        html: `ตรวจสอบโฟลเดอร์ <b>ev${currentStart} - ev${currentEnd}</b><br>` +
                              `<small>เจอ Event ใหม่: ${totalCreated} | รูปใหม่: ${totalSynced}</small>`
                    });

                    // ยิง Axios ไป Backend
                    const response = await axios.get(route('admin.events.sync'), {
                        params: { start: currentStart, end: currentEnd }
                    });

                    const data = response.data;

                    if (data.success) {
                        // รวมยอด
                        totalCreated += data.created;
                        totalSynced += data.synced;
                        totalSkipped += data.skipped;
                        
                        // เช็คเงื่อนไขการหยุด (Smart Stop)
                        if (data.empty_batch) {
                            consecutiveEmptyBatches++;
                            // ถ้าว่างเปล่าติดกัน 2 Batch (10 โฟลเดอร์) ให้หยุดเลย พอแล้ว
                            if (consecutiveEmptyBatches >= 2) break; 
                        } else {
                            consecutiveEmptyBatches = 0; // รีเซ็ตถ้าเจอของ
                        }
                    } else {
                        throw new Error(data.message);
                    }

                    // ขยับไป Batch ถัดไป
                    currentStart += batchSize;
                }

                // 3. เสร็จสิ้นทั้งหมด -> แสดงสรุปผล
                await Swal.fire({
                    title: 'Sync เสร็จสิ้นสมบูรณ์!',
                    html: `ตรวจสอบครบถ้วน<br>` +
                          `Event ใหม่: <b>${totalCreated}</b><br>` +
                          `นำเข้ารูปใหม่: <b>${totalSynced}</b><br>` +
                          `ข้ามรูปเดิม: <b>${totalSkipped}</b>`,
                    icon: 'success'
                });

                // 4. รีโหลดหน้าเว็บเพื่อแสดงข้อมูลใหม่
                router.reload();

            } catch (error) {
                Swal.fire('เกิดข้อผิดพลาด', error.message || 'Connection Error', 'error');
            }
        }
    });
};

// ฟังก์ชันสร้าง Event ใหม่
const createEvent = () => {
    router.post(route('admin.events.create'));
};
</script>

<template>
    <AdminLayout>
        <Head title="จัดการ X-Cademy" />

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-calendar-week text-orange-500"></i> จัดการข่าวสารและกิจกรรม
                </h2>
                <p class="text-slate-500 text-sm">รายการกิจกรรมทั้งหมดในระบบ X-Cademy</p>
            </div>
            
            <div class="flex gap-3">
                <button @click="createEvent" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2 text-sm font-medium">
                    <i class="bi bi-plus-lg"></i> เพิ่มกิจกรรมใหม่
                </button>

                <button @click="syncImages" class="bg-white border border-orange-300 text-orange-600 hover:bg-orange-50 px-4 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2 text-sm font-medium">
                    <i class="bi bi-cloud-download-fill"></i> Sync รูป
                </button>
            </div>
        </div>

        <div v-if="events.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="event in events" :key="event.id" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                
                <div class="relative h-32 bg-slate-100 overflow-hidden">
                    <img v-if="event.images && event.images.length > 0" 
                         :src="event.images[0].image_url + '?tr=w-400,h-300'" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         :alt="event.title">
                    <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                        <i class="bi bi-image text-4xl"></i>
                    </div>
                    
                    <div class="absolute top-2 right-2">
                        <span class="bg-black/70 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full uppercase">
                            {{ event.key }}
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="font-bold text-slate-800 text-sm mb-1 truncate" :title="event.title">
                        {{ event.title || 'ไม่มีชื่อกิจกรรม' }}
                    </h3>
                    
                    <p class="text-xs text-blue-600 mb-2 flex items-center gap-1">
                        <i class="bi bi-calendar3"></i> 
                        {{ event.event_date || '-' }}
                    </p>

                    <p class="text-slate-500 text-xs line-clamp-2 h-8 mb-4">
                        {{ event.description || '-' }}
                    </p>
                    
                    <Link :href="route('admin.events.edit', event.key)" class="block w-full text-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-600 hover:text-white py-1.5 rounded-lg text-xs font-bold transition-colors">
                        <i class="bi bi-gear-fill mr-1"></i> จัดการ
                    </Link>
                </div>
            </div>
        </div>

        <div v-else class="bg-white rounded-xl border-2 border-dashed border-slate-300 p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-3xl"></i>
            </div>
            <h3 class="text-slate-600 font-medium">ยังไม่มีกิจกรรม</h3>
            <p class="text-slate-400 text-sm mt-1">เริ่มต้นโดยการกดปุ่ม "เพิ่มกิจกรรมใหม่"</p>
        </div>

    </AdminLayout>
</template>
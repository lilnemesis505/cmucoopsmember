<script setup>
import { ref } from 'vue';
// ✅ 1. เพิ่ม Link เข้ามาเพื่อให้ปุ่มเปลี่ยนหน้าทำงาน
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';

const props = defineProps({
    members: Object,
    filters: Object,
    hasSearch: Boolean
});

const form = useForm({
    member_id: props.filters.member_id || '',
    id_card: props.filters.id_card || '',
    first_name: props.filters.first_name || '',
    last_name: props.filters.last_name || '',
    phone: props.filters.phone || '',
});

const submitSearch = () => {
    form.get(route('check.member'), {
        preserveState: true,
        replace: true,
    });
};

const clearSearch = () => {
    form.member_id = '';
    form.id_card = '';
    form.first_name = '';
    form.last_name = '';
    form.phone = '';
    router.get(route('check.member'));
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('th-TH', { day: '2-digit', month: '2-digit', year: 'numeric' });
};
</script>

<template>
    <AppLayoutMember> 
        <Head title="ตรวจสอบสถานะสมาชิก" />

        <div class="container py-4 py-md-5">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    
                    <h2 class="text-center mb-2 fw-bold text-primary">
                        <i class="bi bi-person-vcard"></i> ตรวจสอบสถานะสมาชิก
                    </h2>
                    <p class="text-center text-secondary small mb-4">
                        *เพื่อความปลอดภัยของข้อมูล กรุณากรอกข้อมูลให้ถูกต้องครบถ้วน
                    </p>

                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-body bg-light p-3 p-md-4 rounded">
                            <form @submit.prevent="submitSearch">
                                <h5 class="mb-3 text-secondary"><i class="bi bi-search"></i> ค้นหาข้อมูล</h5>
                                <div class="row g-3">
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">รหัสสมาชิก</label>
                                        <input v-model="form.member_id" type="text" class="form-control" placeholder="รหัสสมาชิก">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small text-muted">เลขบัตรประชาชน</label>
                                        <input v-model="form.id_card" type="text" class="form-control" placeholder="เลข 13 หลัก">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">ชื่อจริง</label>
                                        <input v-model="form.first_name" type="text" class="form-control" placeholder="ไม่ต้องมีคำนำหน้า">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">นามสกุล</label>
                                        <input v-model="form.last_name" type="text" class="form-control" placeholder="ระบุนามสกุล">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label small text-muted">เบอร์โทรศัพท์</label>
                                        <input v-model="form.phone" type="text" class="form-control" placeholder="เบอร์โทรศัพท์เต็ม">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <div class="d-grid gap-2 d-md-block">
                                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm" :disabled="form.processing">
                                                <i class="bi bi-search"></i> ค้นหาข้อมูล
                                            </button>
                                            
                                            <button v-if="hasSearch" type="button" @click="clearSearch" class="btn btn-outline-secondary px-4 rounded-pill">
                                                ล้างค่า
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div v-if="hasSearch" class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">ผลการค้นหา</h5>
                        </div>
                        
                        <div class="card-body p-0 d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>รหัสสมาชิก</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>วันที่สมัคร</th>
                                            <th>เบอร์โทรศัพท์</th> 
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="member in members.data" :key="'dt-'+member.id">
                                            <td><span class="badge bg-info text-dark">{{ member.member_id }}</span></td>
                                            <td>{{ member.title_name }}{{ member.first_name }} {{ member.last_name }}</td>
                                            <td><i class="bi bi-calendar-event text-muted"></i> {{ formatDate(member.registry_date) }}</td>
                                            <td>
                                                <span v-if="member.phone" class="text-dark fw-bold" style="letter-spacing: 1px;">
                                                    <i class="bi bi-telephone-fill text-success"></i> {{ member.phone }}
                                                </span>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                            <td><span class="badge bg-success rounded-pill">ปกติ</span></td>
                                        </tr>
                                        <tr v-if="members.data.length === 0">
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-search display-4 d-block mb-3 text-secondary opacity-50"></i>
                                                <h5>ไม่พบข้อมูล</h5>
                                                <p class="small">กรุณาตรวจสอบว่าสะกดชื่อ-นามสกุล หรือกรอกตัวเลขถูกต้องครบถ้วน</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body bg-light d-lg-none p-2">
                            <div v-if="members.data.length === 0" class="text-center py-5 text-muted bg-white rounded shadow-sm">
                                <i class="bi bi-search display-4 d-block mb-3 text-secondary opacity-50"></i>
                                <h5>ไม่พบข้อมูล</h5>
                                <p class="small">กรุณาตรวจสอบข้อมูลให้ถูกต้องครบถ้วน</p>
                            </div>

                            <div v-else class="row g-2">
                                <div v-for="member in members.data" :key="'mb-'+member.id" class="col-12">
                                    <div class="card border-0 shadow-sm mb-2">
                                        <div class="card-body position-relative border-start border-5 border-primary rounded-start">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-info text-dark fs-6">{{ member.member_id }}</span>
                                                <span class="badge bg-success rounded-pill">ปกติ</span>
                                            </div>

                                            <h5 class="fw-bold text-primary mb-2">
                                                {{ member.title_name }}{{ member.first_name }} {{ member.last_name }}
                                            </h5>

                                            <div class="small text-muted">
                                                <div class="mb-1">
                                                    <i class="bi bi-calendar-event me-2"></i> 
                                                    วันที่สมัคร: {{ formatDate(member.registry_date) }}
                                                </div>
                                                <div class="mb-1">
                                                    <i class="bi bi-telephone-fill me-2 text-success"></i> 
                                                    <span v-if="member.phone" class="text-dark fw-bold">{{ member.phone }}</span>
                                                    <span v-else>-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="members.links && members.data.length > 0" class="card-footer bg-white d-flex justify-content-center py-3">
                            <nav>
                                <ul class="pagination mb-0 flex-wrap justify-content-center">
                                    <li v-for="(link, k) in members.links" :key="k" 
                                        class="page-item" 
                                        :class="{ 'active': link.active, 'disabled': !link.url }">
                                        <component 
                                            :is="link.url ? Link : 'span'" 
                                            :href="link.url"
                                            class="page-link" 
                                            v-html="link.label"
                                        />
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayoutMember>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3'; // ใช้ router สำหรับการ search แบบ get
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';
import { Modal } from 'bootstrap';

// 1. รับค่าจาก Controller
const props = defineProps({
    members: Object,      // ข้อมูลสมาชิก (Paginated)
    filters: Object,      // ค่าที่กรอกค้างไว้ในฟอร์ม
    hasSearch: Boolean    // เช็คว่ามีการกดค้นหาหรือยัง
});

// 2. ตั้งค่า Form สำหรับค้นหา
const form = useForm({
    member_id: props.filters.member_id || '',
    id_card: props.filters.id_card || '',
    first_name: props.filters.first_name || '',
    last_name: props.filters.last_name || '',
    phone: props.filters.phone || '',
});

// ฟังก์ชันค้นหา
const submitSearch = () => {
    form.get(route('check.member'), {
        preserveState: true,
        replace: true,
    });
};

// ฟังก์ชันล้างค่า
const clearSearch = () => {
    form.member_id = '';
    form.id_card = '';
    form.first_name = '';
    form.last_name = '';
    form.phone = '';
    router.get(route('check.member'));
};

// 3. Logic สำหรับ Modal แสดงที่อยู่
const modalData = ref({ name: '', address: '' });
let addressModal = null;

onMounted(() => {
    const el = document.getElementById('addressModal');
    if (el) {
        addressModal = new Modal(el);
    }
});

const openAddressModal = (member) => {
    // รวมที่อยู่
    const parts = [
        member.loc_addr,
        member.tambon,
        member.amphur,
        member.province,
        member.zip_code
    ];
    // กรองค่าว่างออกแล้วต่อด้วยช่องว่าง
    const fullAddress = parts.filter(part => part && part !== '-').join(' ') || '-';

    modalData.value = {
        name: `${member.title_name}${member.first_name} ${member.last_name}`,
        address: fullAddress
    };
    
    addressModal.show();
};

// Helper: จัดการวันที่
const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('th-TH', { day: '2-digit', month: '2-digit', year: 'numeric' });
};
</script>

<template>
    <AppLayoutMember>
        <Head title="ตรวจสอบสถานะสมาชิก" />

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    
                    <h2 class="text-center mb-4 fw-bold text-primary">
                        <i class="bi bi-person-vcard"></i> ตรวจสอบสถานะสมาชิก
                    </h2>

                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-body bg-light p-4 rounded">
                            <form @submit.prevent="submitSearch">
                                <h5 class="mb-3 text-secondary"><i class="bi bi-search"></i> ค้นหาข้อมูล</h5>
                                
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted">รหัสสมาชิก</label>
                                        <input v-model="form.member_id" type="text" class="form-control" placeholder="เช่น 132xx">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">เลขบัตรประชาชน</label>
                                        <input v-model="form.id_card" type="text" class="form-control" placeholder="เลข 13 หลัก">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted">ชื่อจริง</label>
                                        <input v-model="form.first_name" type="text" class="form-control" placeholder="ระบุชื่อ">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted">นามสกุล</label>
                                        <input v-model="form.last_name" type="text" class="form-control" placeholder="ระบุนามสกุล">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">เบอร์โทรศัพท์</label>
                                        <input v-model="form.phone" type="text" class="form-control" placeholder="08xxxxxxxx">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm" :disabled="form.processing">
                                            <i class="bi bi-search"></i> ค้นหาข้อมูล
                                        </button>
                                        
                                        <a href="https://www.cmu-coops.com/login.php" target="_blank" class="btn btn-success px-3 ms-2 rounded-pill shadow-sm text-decoration-none fw-bold">
                                            เข้าสู่ระบบสมาชิก
                                        </a>

                                        <button v-if="hasSearch" type="button" @click="clearSearch" class="btn btn-outline-secondary px-4 rounded-pill ms-2">
                                            ล้างค่า
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div v-if="hasSearch" class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">ผลการค้นหา ({{ members.total }} รายการ)</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>รหัสสมาชิก</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>วันที่สมัคร</th>
                                            <th>จังหวัด</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="member in members.data" :key="member.id">
                                            <td>
                                                <span class="badge bg-info text-dark" style="font-size: 0.9rem;">
                                                    {{ member.member_id }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ member.title_name }}{{ member.first_name }} {{ member.last_name }}
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="bi bi-calendar-event"></i> {{ formatDate(member.registry_date) }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                    @click="openAddressModal(member)">
                                                    <i class="bi bi-geo-alt-fill"></i> {{ member.province || 'ไม่ระบุ' }}
                                                </button>
                                            </td>
                                            
                                            <td>
                                                <span v-if="member.phone" class="text-dark fw-bold">
                                                    <i class="bi bi-telephone-fill text-success"></i> {{ member.phone }}
                                                </span>
                                                <span v-else class="text-muted">-</span>
                                            </td>

                                            <td>
                                                <span class="badge bg-success rounded-pill">ปกติ</span>
                                            </td>
                                        </tr>
                                        
                                        <tr v-if="members.data.length === 0">
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                                                <h5>ไม่พบข้อมูลที่ตรงกัน</h5>
                                                <p class="small">กรุณาตรวจสอบความถูกต้องของข้อมูลที่กรอก</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div v-if="members.links && members.data.length > 0" class="card-footer bg-white d-flex justify-content-center py-3">
                            <nav>
                                <ul class="pagination mb-0">
                                    <li v-for="(link, k) in members.links" :key="k" 
                                        class="page-item" 
                                        :class="{ 'active': link.active, 'disabled': !link.url }">
                                        <component 
                                            :is="link.url ? 'Link' : 'span'" 
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

        <div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-house-door-fill"></i> รายละเอียดที่อยู่</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <h5 class="fw-bold text-primary mb-3">{{ modalData.name }}</h5>
                        <div class="p-3 bg-light rounded border">
                            <p class="mb-1 text-muted small">ที่อยู่จัดส่งเอกสาร</p>
                            <h5 class="mb-0">{{ modalData.address }}</h5>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>

    </AppLayoutMember>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';
import { Modal } from 'bootstrap';

// 1. รับค่าจาก Controller (เหมือนเดิม)
const props = defineProps({
    members: Object,
    filters: Object,
    hasSearch: Boolean
});

// 2. ตั้งค่า Form (เหมือนเดิม)
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

// 3. Logic Modal (เหมือนเดิม)
const modalData = ref({ name: '', address: '' });
let addressModal = null;

onMounted(() => {
    const el = document.getElementById('addressModal');
    if (el) {
        addressModal = new Modal(el);
    }
});

const openAddressModal = (member) => {
    const parts = [
        member.loc_addr,
        member.tambon,
        member.amphur,
        member.province,
        member.zip_code
    ];
    const fullAddress = parts.filter(part => part && part !== '-').join(' ') || '-';

    modalData.value = {
        name: `${member.title_name}${member.first_name} ${member.last_name}`,
        address: fullAddress
    };
    
    addressModal.show();
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
                    
                    <h2 class="text-center mb-4 fw-bold text-primary">
                        <i class="bi bi-person-vcard"></i> ตรวจสอบสถานะสมาชิก
                    </h2>

                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-body bg-light p-3 p-md-4 rounded">
                            <form @submit.prevent="submitSearch">
                                <h5 class="mb-3 text-secondary"><i class="bi bi-search"></i> ค้นหาข้อมูล</h5>
                                
                                <div class="row g-3">
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">รหัสสมาชิก</label>
                                        <input v-model="form.member_id" type="text" class="form-control" placeholder="เช่น 132xx">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small text-muted">เลขบัตรประชาชน</label>
                                        <input v-model="form.id_card" type="text" class="form-control" placeholder="เลข 13 หลัก">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">ชื่อจริง</label>
                                        <input v-model="form.first_name" type="text" class="form-control" placeholder="ระบุชื่อ">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label class="form-label small text-muted">นามสกุล</label>
                                        <input v-model="form.last_name" type="text" class="form-control" placeholder="ระบุนามสกุล">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label small text-muted">เบอร์โทรศัพท์</label>
                                        <input v-model="form.phone" type="text" class="form-control" placeholder="08xxxxxxxx">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <div class="d-grid gap-2 d-md-block">
                                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm" :disabled="form.processing">
                                                <i class="bi bi-search"></i> ค้นหาข้อมูล
                                            </button>
                                            
                                            <a href="https://www.cmu-coops.com/login.php" target="_blank" class="btn btn-success px-3 rounded-pill shadow-sm text-decoration-none fw-bold">
                                                เข้าสู่ระบบสมาชิก
                                            </a>

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
                            <span class="badge bg-white text-primary">{{ members.total }} รายการ</span>
                        </div>
                        
                        <div class="card-body p-0 d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>รหัสสมาชิก</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>วันที่สมัคร</th>
                                            <th>ที่อยู่</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="member in members.data" :key="'dt-'+member.id">
                                            <td>
                                                <span class="badge bg-info text-dark">{{ member.member_id }}</span>
                                            </td>
                                            <td>{{ member.title_name }}{{ member.first_name }} {{ member.last_name }}</td>
                                            <td><i class="bi bi-calendar-event text-muted"></i> {{ formatDate(member.registry_date) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" @click="openAddressModal(member)">
                                                    <i class="bi bi-geo-alt-fill"></i> {{ member.province || 'ไม่ระบุ' }}
                                                </button>
                                            </td>
                                            <td>
                                                <span v-if="member.phone" class="text-dark fw-bold"><i class="bi bi-telephone-fill text-success"></i> {{ member.phone }}</span>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                            <td><span class="badge bg-success rounded-pill">ปกติ</span></td>
                                        </tr>
                                        <tr v-if="members.data.length === 0">
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                                                <h5>ไม่พบข้อมูล</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body bg-light d-lg-none p-2">
                            <div v-if="members.data.length === 0" class="text-center py-5 text-muted bg-white rounded shadow-sm">
                                <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                                <h5>ไม่พบข้อมูล</h5>
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

                                            <div class="small text-muted mb-3">
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

                                            <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill" @click="openAddressModal(member)">
                                                <i class="bi bi-geo-alt-fill"></i> ดูที่อยู่ ({{ member.province || 'ไม่ระบุ' }})
                                            </button>
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

        <Teleport to="body">
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
        </Teleport>
    </AppLayoutMember>
</template>
<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    members: Object,
    filters: Object,
});

// --- 1. Search Logic ---
const search = ref({ ...props.filters });

// ค้นหาเมื่อพิมพ์ (หน่วงเวลา 500ms)
watch(search, debounce((value) => {
    router.get(route('admin.members.index'), value, { preserveState: true, replace: true });
}, 500), { deep: true });

// ล้างการค้นหา
const clearSearch = () => {
    search.value = { member_id: '', first_name: '', last_name: '', phone: '' };
    router.get(route('admin.members.index'));
};

// --- 2. Import Logic ---
const importForm = useForm({ file: null });
const fileInput = ref(null);

const handleImport = () => {
    if (!importForm.file) return alert('กรุณาเลือกไฟล์');
    importForm.post(route('admin.members.import'), {
        onSuccess: () => {
            importForm.reset();
            if(fileInput.value) fileInput.value.value = ''; // Reset input file
            // Alert จะเด้งจาก Flash Message ของ Backend
        },
        onError: () => alert('เกิดข้อผิดพลาดในการนำเข้าข้อมูล')
    });
};

// --- 3. Truncate Logic (ล้างข้อมูล) ---
const showTruncateModal = ref(false);
const truncateForm = useForm({ password: '' });

const handleTruncate = () => {
    truncateForm.delete(route('admin.members.truncate'), {
        onSuccess: () => { 
            showTruncateModal.value = false; 
            truncateForm.reset(); 
        }
    });
};

// --- 4. Delete Logic ---
const handleDelete = (id) => {
    if(confirm('ยืนยันการลบข้อมูลสมาชิกรายนี้?')) {
        router.delete(route('admin.members.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="จัดการข้อมูลสมาชิก" />

        <div v-if="importForm.processing" class="fixed inset-0 z-[9999] bg-black/60 flex flex-col items-center justify-center text-white backdrop-blur-sm">
            <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin mb-4"></div>
            <h4 class="text-xl font-bold">กำลังนำเข้าข้อมูล...</h4>
            <p class="text-sm opacity-80">กรุณารอสักครู่ อย่าปิดหน้าต่างนี้</p>
        </div>

        <div class="container mx-auto px-4 py-6">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-slate-700 flex items-center gap-2">
                    <i class="bi bi-people-fill"></i> จัดการข้อมูลสมาชิก
                </h2>
                <Link :href="route('admin.members.create')" class="btn-primary">
                    <i class="bi bi-plus-lg"></i> เพิ่มสมาชิกรายคน
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-green-500 overflow-hidden mb-6">
                <div class="bg-green-600 text-white px-4 py-3 font-bold flex items-center gap-2">
                    <i class="bi bi-file-earmark-spreadsheet"></i> นำเข้าข้อมูลจาก Excel
                </div>
                <div class="p-6">
                    <form @submit.prevent="handleImport" class="flex flex-col md:flex-row items-center gap-4">
                        <div class="flex-shrink-0 font-medium text-slate-700">เลือกไฟล์ Excel (.xlsx, .csv):</div>
                        <div class="flex-grow w-full md:w-auto">
                            <input 
                                type="file" 
                                ref="fileInput"
                                @input="importForm.file = $event.target.files[0]" 
                                class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100 border border-slate-300 rounded-md p-1" 
                                required 
                            />
                            <div v-if="importForm.errors.file" class="text-red-500 text-xs mt-1">{{ importForm.errors.file }}</div>
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button type="submit" :disabled="importForm.processing" class="btn-success flex-grow justify-center md:flex-grow-0">
                                <i class="bi bi-cloud-upload"></i> Upload & Import
                            </button>
                            <button type="button" @click="showTruncateModal = true" class="btn-danger flex-grow justify-center md:flex-grow-0">
                                <i class="bi bi-trash-fill"></i> ล้างข้อมูลทั้งหมด
                            </button>
                        </div>
                    </form>
                    <p class="text-xs text-slate-500 mt-2">* คำเตือน ในการอัพโหลด excel ให้อัพทีละช่วงปี ไม่ให้อัพทีละหลายๆหน้า</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                
                <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <div class="md:col-span-2">
                            <input v-model="search.member_id" type="text" placeholder="รหัสสมาชิก" class="form-input" />
                        </div>
                        <div class="md:col-span-3">
                            <input v-model="search.first_name" type="text" placeholder="ชื่อจริง" class="form-input" />
                        </div>
                        <div class="md:col-span-3">
                            <input v-model="search.last_name" type="text" placeholder="นามสกุล" class="form-input" />
                        </div>
                        <div class="md:col-span-3">
                            <input v-model="search.phone" type="text" placeholder="เบอร์โทรศัพท์" class="form-input" />
                        </div>
                        <div class="md:col-span-1 text-center">
                            <button disabled class="w-full bg-blue-500 text-white rounded p-2 opacity-50 cursor-default">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div v-if="search.member_id || search.first_name || search.last_name || search.phone" class="mt-2 text-right">
                        <button @click="clearSearch" class="text-red-500 text-sm hover:underline">
                            <i class="bi bi-x-circle"></i> ล้างการค้นหา
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-100 text-slate-600 text-sm uppercase font-semibold">
                            <tr>
                                <th class="p-3 border-b">รหัสสมาชิก</th>
                                <th class="p-3 border-b">เลขบัตร ปชช.</th>
                                <th class="p-3 border-b">ชื่อ - นามสกุล</th>
                                <th class="p-3 border-b">ข้อมูลการสมัคร</th>
                                <th class="p-3 border-b w-1/4">ที่อยู่</th>
                                <th class="p-3 border-b">เบอร์โทร</th>
                                <th class="p-3 border-b text-right">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                            <tr v-for="member in members.data" :key="member.id" class="hover:bg-slate-50 transition-colors">
                                <td class="p-3">
                                    <span class="bg-slate-200 text-slate-700 px-2 py-1 rounded text-xs font-bold font-mono">
                                        {{ member.member_id }}
                                    </span>
                                </td>
                                <td class="p-3 text-slate-500">{{ member.id_card || '-' }}</td>
                                <td class="p-3 font-medium text-slate-800">
                                    {{ member.title_name }}{{ member.first_name }} {{ member.last_name }}
                                </td>
                                <td class="p-3">
                                    <div class="text-xs text-slate-500 flex items-center gap-1">
                                        <i class="bi bi-calendar"></i> {{ member.registry_date || '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                        <i class="bi bi-flag"></i> {{ member.nation || '-' }}
                                    </div>
                                </td>
                                <td class="p-3 text-xs text-slate-500 leading-relaxed">
                                    {{ member.loc_addr }} 
                                    {{ member.tambon }} 
                                    {{ member.amphur }} 
                                    {{ member.province }} 
                                    {{ member.zip_code }}
                                </td>
                                <td class="p-3">{{ member.phone || '-' }}</td>
                                <td class="p-3 text-right whitespace-nowrap">
                                    <Link :href="route('admin.members.edit', member.id)" class="btn-icon-warning mr-1">
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button @click="handleDelete(member.id)" class="btn-icon-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="members.data.length === 0">
                                <td colspan="7" class="p-10 text-center text-slate-400">
                                    <i class="bi bi-inbox text-4xl block mb-2 opacity-50"></i>
                                    ไม่พบข้อมูลสมาชิก
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-center" v-if="members.links.length > 3">
                    <div class="flex gap-1">
                        <Link v-for="(link, k) in members.links" :key="k" 
                              :href="link.url || '#'" 
                              v-html="link.label"
                              class="px-3 py-1 rounded text-sm transition-colors border"
                              :class="{
                                  'bg-blue-600 text-white border-blue-600': link.active, 
                                  'bg-white text-slate-600 border-slate-200 hover:bg-slate-100': !link.active,
                                  'opacity-50 pointer-events-none': !link.url
                              }" />
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showTruncateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showTruncateModal = false"></div>
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-md relative z-10 overflow-hidden animate-zoom-in">
                <div class="bg-red-600 text-white px-4 py-3 font-bold flex justify-between items-center">
                    <span><i class="bi bi-exclamation-triangle-fill"></i> คำเตือน: ล้างข้อมูลทั้งหมด</span>
                    <button @click="showTruncateModal = false" class="text-white hover:text-red-200"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="p-6">
                    <p class="text-red-600 font-bold mb-2">คุณกำลังจะลบข้อมูลสมาชิก "ทั้งหมด" ออกจากระบบ!</p>
                    <p class="text-slate-600 text-sm mb-4">ข้อมูลจะไม่สามารถกู้คืนได้ เพื่อความปลอดภัย กรุณากรอกรหัสผ่านของคุณเพื่อยืนยัน:</p>
                    
                    <form @submit.prevent="handleTruncate">
                        <label class="block text-sm font-medium text-slate-700 mb-1">รหัสผ่าน Admin:</label>
                        <input type="password" v-model="truncateForm.password" class="form-input w-full mb-4" placeholder="กรอกรหัสผ่านของคุณ..." required />
                        
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showTruncateModal = false" class="px-4 py-2 bg-slate-200 text-slate-700 rounded hover:bg-slate-300 text-sm">
                                ยกเลิก
                            </button>
                            <button type="submit" :disabled="truncateForm.processing" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-bold">
                                ยืนยันลบข้อมูลทั้งหมด
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>

<style scoped>
/* Utility Classes ให้เหมือน Bootstrap */
.form-input {
    @apply w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3;
}
.btn-primary {
    @apply bg-blue-600 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-700 text-sm font-medium transition-colors flex items-center gap-2;
}
.btn-success {
    @apply bg-green-600 text-white px-4 py-2 rounded shadow-sm hover:bg-green-700 text-sm font-medium transition-colors flex items-center gap-2;
}
.btn-danger {
    @apply bg-red-600 text-white px-4 py-2 rounded shadow-sm hover:bg-red-700 text-sm font-medium transition-colors flex items-center gap-2;
}
.btn-icon-warning {
    @apply inline-flex items-center justify-center w-8 h-8 bg-yellow-400 text-yellow-900 rounded hover:bg-yellow-500 transition-colors;
}
.btn-icon-danger {
    @apply inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors;
}

/* Animation */
.animate-zoom-in { animation: zoomIn 0.2s ease-out; }
@keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
</style>
<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
    member_id: '',
    first_name: '',
    last_name: '',
    phone: '',
    // เพิ่ม field อื่นๆ ตาม DB ของคุณ
});

const submit = () => {
    form.post(route('admin.members.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="เพิ่มสมาชิกใหม่" />

        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">เพิ่มสมาชิกใหม่</h2>

            <form @submit.prevent="submit" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">รหัสสมาชิก <span class="text-red-500">*</span></label>
                    <input v-model="form.member_id" type="text" class="form-input w-full rounded-lg border-slate-300" required />
                    <div v-if="form.errors.member_id" class="text-red-500 text-xs mt-1">{{ form.errors.member_id }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ชื่อจริง <span class="text-red-500">*</span></label>
                        <input v-model="form.first_name" type="text" class="form-input w-full rounded-lg border-slate-300" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">นามสกุล <span class="text-red-500">*</span></label>
                        <input v-model="form.last_name" type="text" class="form-input w-full rounded-lg border-slate-300" required />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">เบอร์โทรศัพท์</label>
                    <input v-model="form.phone" type="text" class="form-input w-full rounded-lg border-slate-300" />
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <Link :href="route('admin.members.index')" class="text-slate-500 hover:text-slate-700">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold shadow-md">
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>x
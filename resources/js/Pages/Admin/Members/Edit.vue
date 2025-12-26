<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ member: Object });

const form = useForm({
    member_id: props.member.member_id,
    first_name: props.member.first_name,
    last_name: props.member.last_name,
    phone: props.member.phone,
});

const submit = () => {
    form.put(route('admin.members.update', props.member.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขข้อมูลสมาชิก" />

        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">แก้ไขข้อมูลสมาชิก</h2>

            <form @submit.prevent="submit" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">รหัสสมาชิก <span class="text-red-500">*</span></label>
                    <input v-model="form.member_id" type="text" class="form-input w-full rounded-lg border-slate-300 bg-slate-100" readonly />
                    <p class="text-xs text-slate-400 mt-1">*รหัสสมาชิกไม่ควรแก้ไขหากไม่จำเป็น</p>
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
                    <button type="submit" :disabled="form.processing" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 font-bold shadow-md">
                        บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
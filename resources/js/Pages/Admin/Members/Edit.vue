<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ member: Object });

const form = useForm({
    member_id: props.member.member_id,
    id_card: props.member.id_card || '',      // [เพิ่ม]
    first_name: props.member.first_name,
    last_name: props.member.last_name,
    birthday: props.member.birthday || '',    // [เพิ่ม]
    phone: props.member.phone,
    address: props.member.address || '',      // [เพิ่ม]
});

const submit = () => {
    form.put(route('admin.members.update', props.member.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="แก้ไขข้อมูลสมาชิก" />

        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="bi bi-person-gear text-yellow-500"></i> แก้ไขข้อมูลสมาชิก
            </h2>

            <form @submit.prevent="submit" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            รหัสสมาชิก <span class="text-red-500">*</span>
                        </label>
                        <input 
                            v-model="form.member_id" 
                            type="text" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2.5 text-slate-500 cursor-not-allowed focus:outline-none"
                            readonly 
                        />
                        <p class="text-[10px] text-slate-400 mt-1">
                            <i class="bi bi-info-circle"></i> รหัสสมาชิกไม่สามารถแก้ไขได้
                        </p>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            เลขบัตรประชาชน
                        </label>
                        <input 
                            v-model="form.id_card" 
                            type="text" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none"
                            placeholder="เลขบัตร 13 หลัก" 
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            ชื่อจริง <span class="text-red-500">*</span>
                        </label>
                        <input 
                            v-model="form.first_name" 
                            type="text" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none"
                            required 
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            นามสกุล <span class="text-red-500">*</span>
                        </label>
                        <input 
                            v-model="form.last_name" 
                            type="text" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none"
                            required 
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            วันเกิด
                        </label>
                        <input 
                            v-model="form.birthday" 
                            type="date" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            เบอร์โทรศัพท์
                        </label>
                        <input 
                            v-model="form.phone" 
                            type="tel" 
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none"
                            placeholder="08x-xxx-xxxx"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        ที่อยู่
                    </label>
                    <textarea 
                        v-model="form.address" 
                        rows="3" 
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-slate-800 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all outline-none resize-none"
                        placeholder="บ้านเลขที่, หมู่, ซอย, ถนน..."
                    ></textarea>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <Link :href="route('admin.members.index')" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        ยกเลิก
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing" 
                        class="px-6 py-2.5 text-sm font-bold text-white bg-yellow-500 rounded-lg shadow-md hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-200 transition-all flex items-center gap-2"
                    >
                        <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                        <span v-else><i class="bi bi-save"></i> บันทึกการแก้ไข</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
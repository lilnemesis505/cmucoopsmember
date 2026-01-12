<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('admin.register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="ลงทะเบียนผู้ดูแลระบบ" />

    <div class="min-h-screen flex items-center justify-center bg-slate-100 font-sans p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <div class="bg-purple-600 p-8 text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="bi bi-person-plus-fill text-3xl text-purple-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">ลงทะเบียน Admin</h2>
                <p class="text-purple-100 text-sm mt-1">สร้างบัญชีผู้ดูแลระบบใหม่</p>
            </div>

            <div class="p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ชื่อผู้ใช้งาน (Name)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input v-model="form.name" type="text" class="pl-10 w-full border-slate-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" placeholder="ชื่อเรียก หรือ ชื่อจริง" required autofocus />
                        </div>
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">อีเมล (Email)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input v-model="form.email" type="email" class="pl-10 w-full border-slate-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" placeholder="admin@example.com" required />
                        </div>
                        <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">รหัสผ่าน (Password)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input v-model="form.password" type="password" class="pl-10 w-full border-slate-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" placeholder="อย่างน้อย 8 ตัวอักษร" required />
                        </div>
                        <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ยืนยันรหัสผ่าน</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <input v-model="form.password_confirmation" type="password" class="pl-10 w-full border-slate-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" placeholder="กรอกรหัสผ่านอีกครั้ง" required />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="form.processing" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg shadow-md transition-all flex justify-center items-center gap-2">
                            <i v-if="form.processing" class="bi bi-hourglass-split animate-spin"></i>
                            <span>{{ form.processing ? 'กำลังบันทึก...' : 'ลงทะเบียน' }}</span>
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <Link :href="route('admin.login')" class="text-sm text-slate-500 hover:text-purple-600 font-medium">
                            <i class="bi bi-arrow-left"></i> กลับไปหน้าเข้าสู่ระบบ
                        </Link>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
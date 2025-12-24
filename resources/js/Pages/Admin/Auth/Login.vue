<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-[#050505] font-sans selection:bg-purple-500 selection:text-white overflow-hidden relative">
        <Head title="เข้าสู่ระบบ" />

        <div class="absolute w-[500px] h-[500px] bg-purple-600/30 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full max-w-sm p-8 rounded-lg bg-[#121212] border border-purple-500/50 shadow-[0_0_40px_rgba(147,51,234,0.3)] relative z-10">
            
            <h3 class="text-center text-2xl font-bold text-white mb-6 uppercase tracking-wider">
                CMUCOOP ADMIN
            </h3>

            <form @submit.prevent="submit" class="space-y-4">
                
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Username</label>
                    <input 
                        v-model="form.username" 
                        type="text" 
                        class="w-full px-4 py-2 bg-[#1a1a1a] border border-gray-700 rounded text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors placeholder-gray-600"
                        placeholder="Enter your Username"
                        required 
                    />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <input 
                        v-model="form.password" 
                        type="password" 
                        class="w-full px-4 py-2 bg-[#1a1a1a] border border-gray-700 rounded text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors placeholder-gray-600"
                        placeholder="Enter your password"
                        required 
                    />
                </div>

                <div class="flex items-center justify-between text-xs text-gray-500 mt-2">
                    <label class="flex items-center gap-2 cursor-pointer hover:text-purple-400 transition">
                        <input v-model="form.remember" type="checkbox" class="accent-purple-600 rounded">
                        Remember me
                    </label>
                    <span class="hover:text-purple-400 cursor-pointer transition">Forgot Password?</span>
                </div>

                <div class="pt-4">
                    <button 
                        :disabled="form.processing" 
                        type="submit" 
                        class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded font-semibold shadow-[0_0_15px_rgba(147,51,234,0.5)] hover:shadow-[0_0_25px_rgba(147,51,234,0.7)] transition-all duration-300"
                    >
                        <span v-if="form.processing">Logging in...</span>
                        <span v-else>Login</span>
                    </button>
                </div>
                
                <div v-if="form.errors.username" class="mt-3 text-sm text-red-400 text-center bg-red-900/20 py-2 rounded border border-red-500/30">
                    {{ form.errors.username }}
                </div>
            </form>
        </div>

    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap');

.font-sans { 
    font-family: 'Prompt', sans-serif; 
}
</style>
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
    <div class="min-h-screen flex items-center justify-center bg-[#050505] relative overflow-hidden font-sans selection:bg-indigo-500 selection:text-white">
        <Head title="Admin Login" />

        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-[128px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] pointer-events-none"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5 pointer-events-none"></div>

        <div class="w-full max-w-md p-10 rounded-3xl bg-white/5 backdrop-blur-3xl border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)] relative z-10 animate-fade-in-up">

            <form @submit.prevent="submit" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider ml-1">Username / Email</label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl blur opacity-0 group-hover:opacity-30 transition duration-500"></div>
                        <input 
                            v-model="form.username" 
                            type="text" 
                            class="relative w-full px-5 py-3.5 bg-black/40 border border-white/10 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all duration-300"
                            placeholder="admin@cmu.coop"
                            required 
                        />
                        <i class="bi bi-person absolute right-4 top-3.5 text-slate-500"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider ml-1">Password</label>
                    <div class="relative group">
                         <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl blur opacity-0 group-hover:opacity-30 transition duration-500"></div>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            class="relative w-full px-5 py-3.5 bg-black/40 border border-white/10 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all duration-300"
                            placeholder="••••••••"
                            required 
                        />
                        <i class="bi bi-lock absolute right-4 top-3.5 text-slate-500"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <button 
                        :disabled="form.processing" 
                        type="submit" 
                        class="relative w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl font-bold text-lg tracking-wide shadow-lg shadow-blue-900/20 transition-all duration-300 transform active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed group overflow-hidden"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <span v-if="form.processing">Authenticating...</span>
                            <span v-else>SIGN IN</span>
                            <i v-if="!form.processing" class="bi bi-arrow-right-short text-2xl group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute top-0 -left-[100%] w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-[25deg] group-hover:animate-shine"></div>
                    </button>
                </div>
                
                <div v-if="form.errors.username" class="p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm text-center animate-shake">
                    <i class="bi bi-exclamation-circle mr-2"></i>{{ form.errors.username }}
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-xs text-slate-600">
                    &copy; {{ new Date().getFullYear() }} CMU Cooperative. Restricted Area.
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;900&display=swap');
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

.font-sans { 
    font-family: 'Prompt', sans-serif; 
}

/* Shine Animation for Button */
@keyframes shine {
    0% { left: -100%; }
    100% { left: 200%; }
}
.group-hover\:animate-shine:hover {
    animation: shine 0.7s;
}

/* Entrance Animation */
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* Shake Animation for Error */
.animate-shake {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}
@keyframes shake {
    10%, 90% { transform: translate3d(-1px, 0, 0); }
    20%, 80% { transform: translate3d(2px, 0, 0); }
    30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
    40%, 60% { transform: translate3d(4px, 0, 0); }
}
</style>
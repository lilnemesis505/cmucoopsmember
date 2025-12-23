<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const isDarkMode = ref(false);

// ฟังก์ชันสลับโหมด
const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

// เช็คค่าเริ่มต้น
onMounted(() => {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDarkMode.value = false;
        document.documentElement.classList.remove('dark');
    }
});
</script>

<template>
    <Head>
        <component :is="'script'" src="https://cdn.tailwindcss.com"></component>
        <component :is="'script'">
            tailwind.config = { 
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: { sans: ['Prompt', 'sans-serif'] }
                    }
                }
            }
        </component>
    </Head>

    <div class="min-h-screen flex flex-col bg-slate-50 dark:bg-slate-900 font-sans text-slate-600 dark:text-slate-300 transition-colors duration-300">
        
        <main class="flex-grow relative z-10">
            <slot />
        </main>

        <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 pt-10 pb-6 mt-auto relative z-20 text-sm transition-colors duration-300">
            <div class="container mx-auto px-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="leading-tight">
                                <h5 class="font-bold text-slate-800 dark:text-white text-lg">CMUCOOP</h5>
                                <span class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">สหกรณ์มหาวิทยาลัยเชียงใหม่</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-4 pr-4">
                            ศูนย์กลางการเชื่อมต่อสมาชิกสหกรณ์ การเรียนรู้ตลอดชีวิต และร้านค้าออนไลน์
                        </p>
                        <div class="flex space-x-3">
                            <a href="https://www.facebook.com/share/1AD8Pi4Wf7/" target="_blank" class="w-9 h-9 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center transition-colors hover:bg-blue-600 hover:text-white shadow-sm">
                                <i class="bi bi-facebook text-lg"></i>
                            </a>
                            <a href="https://line.me/R/ti/p/@cmucoop" target="_blank" class="w-9 h-9 rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center transition-colors hover:bg-green-600 hover:text-white shadow-sm">
                                <i class="bi bi-line text-lg"></i>
                            </a>
                             <a href="mailto:cmucoop@gmail.com" class="w-9 h-9 rounded-full bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center transition-colors hover:bg-orange-600 hover:text-white shadow-sm">
                                <i class="bi bi-envelope-fill text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h6 class="font-bold text-slate-800 dark:text-white text-sm mb-4 border-l-4 border-orange-500 pl-3">ติดต่อเรา</h6>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start">
                                <i class="bi bi-geo-alt-fill text-slate-400 mt-1 mr-2.5"></i>
                                <span>
                                    <strong class="text-slate-700 dark:text-slate-200 block">จุดสมาชิกสัมพันธ์ (สนญ.)</strong>
                                    มหาวิทยาลัยเชียงใหม่
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="bi bi-telephone-fill text-slate-400 mr-2.5"></i>
                                <span class="text-slate-700 dark:text-slate-300">063-1385154, 0-5321-7139</span>
                            </li>
                            <li class="flex items-center">
                                <i class="bi bi-clock-fill text-slate-400 mr-2.5"></i>
                                <span>จันทร์ - ศุกร์ : 09.00 - 16.00 น.</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-bold text-slate-800 dark:text-white text-sm mb-4 border-l-4 border-blue-500 pl-3">เมนูลัด</h6>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="https://www.cmu-coops.com/" target="_blank" class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-xs mr-2 group-hover:text-blue-500"></i> 
                                    ร้านสหกรณ์ มช.
                                </a>
                            </li>
                            <li>
                                <a href="https://www.cmu-coops.com/location.php" target="_blank" class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-xs mr-2 group-hover:text-blue-500"></i> 
                                    ตำแหน่งสาขา
                                </a>
                            </li>
                            <li>
                                <a href="https://www.cmu-coops.com/coopnews.php" target="_blank" class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-xs mr-2 group-hover:text-blue-500"></i> 
                                    ข่าวสารประชาสัมพันธ์
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col items-start lg:items-end justify-start">
                        <h6 class="font-bold text-slate-800 dark:text-white text-sm mb-4 lg:hidden">การตั้งค่า</h6>
                        
                        <button 
                            @click="toggleTheme" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all shadow-sm border border-slate-200 dark:border-slate-600 group"
                        >
                            <div class="relative w-5 h-5 overflow-hidden">
                                <i v-if="isDarkMode" class="bi bi-moon-stars-fill text-yellow-400 text-sm absolute inset-0 animate-fade-in"></i>
                                <i v-else class="bi bi-sun-fill text-orange-500 text-sm absolute inset-0 animate-fade-in"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-200">
                                {{ isDarkMode ? 'Dark Mode' : 'Light Mode' }}
                            </span>
                        </button>
                    </div>

                </div>

                <div class="border-t border-slate-100 dark:border-slate-700/50 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-slate-400 dark:text-slate-500">
                    <p>&copy; {{ new Date().getFullYear() }} Chiang Mai University Cooperative. All Rights Reserved.</p>
                    <div class="mt-2 md:mt-0 space-x-4">
                        <a href="#" class="hover:text-slate-600 dark:hover:text-slate-300 transition-colors">นโยบายความเป็นส่วนตัว</a>
                        <span class="text-slate-200 dark:text-slate-700">|</span>
                        <a href="#" class="hover:text-slate-600 dark:hover:text-slate-300 transition-colors">ข้อตกลงการใช้งาน</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
    
    /* Animation ไอคอนสลับโหมด */
    .animate-fade-in {
        animation: rotateScale 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes rotateScale {
        from { opacity: 0; transform: scale(0.5) rotate(-90deg); }
        to { opacity: 1; transform: scale(1) rotate(0deg); }
    }
</style>
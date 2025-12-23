<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-50 font-sans text-slate-600">
        
        <main class="flex-grow relative z-10">
            <slot />
        </main>

        <footer class="bg-white border-t border-slate-200 pt-10 pb-6 mt-auto relative z-20 text-sm">
            <div class="container mx-auto px-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="leading-tight">
                                <h5 class="font-bold text-slate-800 text-base">CMUCOOP</h5>
                                <span class="text-[10px] text-slate-500 uppercase tracking-wider">สหกรณ์มหาวิทยาลัยเชียงใหม่</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed mb-4 pr-4">
                            ศูนย์กลางการเชื่อมต่อสมาชิกสหกรณ์ การเรียนรู้ตลอดชีวิต และร้านค้าออนไลน์
                        </p>
                        <div class="flex space-x-2">
                            <a href="https://www.facebook.com/share/1AD8Pi4Wf7/" target="_blank" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center transition-colors hover:bg-blue-600 hover:text-white">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://line.me/R/ti/p/@cmucoop" target="_blank" class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center transition-colors hover:bg-green-600 hover:text-white">
                                <i class="bi bi-line"></i>
                            </a>
                            <a href="mailto:cmucoop@gmail.com" class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center transition-colors hover:bg-orange-600 hover:text-white">
                                <i class="bi bi-envelope-fill"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h6 class="font-bold text-slate-800 text-sm mb-3 border-l-4 border-orange-500 pl-2">ติดต่อเรา</h6>
                        <ul class="space-y-2 text-xs">
                            <li class="flex items-start">
                                <i class="bi bi-geo-alt-fill text-slate-400 mt-0.5 mr-2"></i>
                                <span>
                                    <strong class="text-slate-700 block">จุดสมาชิกสัมพันธ์ (สนญ.)</strong>
                                    มหาวิทยาลัยเชียงใหม่
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="bi bi-telephone-fill text-slate-400 mr-2"></i>
                                <span class="text-slate-700 font-medium">063-1385154, 0-5321-7139</span>
                            </li>
                            <li class="flex items-center">
                                <i class="bi bi-clock-fill text-slate-400 mr-2"></i>
                                <span>จันทร์ - ศุกร์ : 09.00 - 16.00 น.</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-bold text-slate-800 text-sm mb-3 border-l-4 border-blue-500 pl-2">เมนูลัด</h6>
                        <ul class="space-y-2 text-xs">
                            <li>
                                <a href="https://www.cmu-coops.com/" target="_blank" class="flex items-center hover:text-blue-600 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-[10px] mr-1 group-hover:text-blue-500"></i> 
                                    ร้านสหกรณ์ มช.
                                </a>
                            </li>
                            <li>
                                <a href="https://www.cmu-coops.com/location.php" target="_blank" class="flex items-center hover:text-blue-600 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-[10px] mr-1 group-hover:text-blue-500"></i> 
                                    ตำแหน่งสาขา
                                </a>
                            </li>
                            <li>
                                <a href="https://www.cmu-coops.com/coopnews.php" target="_blank" class="flex items-center hover:text-blue-600 transition-colors group">
                                    <i class="bi bi-chevron-right text-slate-300 text-[10px] mr-1 group-hover:text-blue-500"></i> 
                                    ข่าวสารประชาสัมพันธ์
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="hidden lg:block">
                        </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-400">
                    <p>&copy; {{ new Date().getFullYear() }} Chiang Mai University Cooperative. All Rights Reserved.</p>
                    <div class="mt-2 md:mt-0 space-x-3">
                        <a href="#" class="hover:text-slate-600">นโยบายความเป็นส่วนตัว</a>
                        <span class="text-slate-200">|</span>
                        <a href="#" class="hover:text-slate-600">ข้อตกลงการใช้งาน</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
    .font-sans { font-family: 'Prompt', sans-serif; }
</style>
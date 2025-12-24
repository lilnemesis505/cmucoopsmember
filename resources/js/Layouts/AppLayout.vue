<script setup>
// AppLayout.vue
</script>

<template>
    <div class="min-h-screen flex flex-col font-sans antialiased bg-slate-900 text-slate-600 selection:bg-blue-500 selection:text-white">
        
        <main class="flex-grow w-full">
            <slot />
        </main>

     <footer class="bg-white border-t border-slate-100 py-6 relative z-20 text-sm text-slate-500">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-12">
                    <div class="md:col-span-4 lg:col-span-5">
                        <div class="mb-6">
                            <h5 class="font-bold text-slate-900 text-lg mb-1">สหกรณ์มหาวิทยาลัยเชียงใหม่</h5>
                            <p class="text-slate-500 text-sm">Chiang Mai University Cooperative</p>
                        </div>
                        <p class="text-slate-500 leading-relaxed mb-6 max-w-sm">
                            ศูนย์กลางการเชื่อมต่อสมาชิกสหกรณ์ ส่งเสริมการออม การเรียนรู้ตลอดชีวิต และสวัสดิการเพื่อความมั่นคง
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="social-btn bg-[#1877F2] text-white"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-btn bg-[#00C300] text-white"><i class="bi bi-line"></i></a>
                            <a href="#" class="social-btn bg-slate-100 text-slate-600 hover:bg-red-500 hover:text-white"><i class="bi bi-envelope-fill"></i></a>
                        </div>
                    </div>
                    <div class="md:col-span-4 lg:col-span-4">
                        <h6 class="font-bold text-slate-900 mb-4 text-base">ติดต่อสอบถาม</h6>
                        <ul class="space-y-4 text-slate-500">
                            <li class="flex items-start">
                                <i class="bi bi-geo-alt-fill text-blue-500 mt-1 mr-3 text-lg"></i>
                                <span>สำนักงานใหญ่ (สนญ.) มหาวิทยาลัยเชียงใหม่ <br>อ.เมือง จ.เชียงใหม่ 50200</span>
                            </li>
                            <li class="flex items-center">
                                <i class="bi bi-telephone-fill text-blue-500 mr-3 text-lg"></i>
                                <span class="font-medium text-slate-700">053-217-139</span>
                            </li>
                        </ul>
                    </div>
                    <div class="md:col-span-4 lg:col-span-3">
                        <h6 class="font-bold text-slate-900 mb-4 text-base">ลิงก์ที่เกี่ยวข้อง</h6>
                        <ul class="space-y-3">
                            <li><a href="https://www.cmu-coops.com/" target="_blank" class="footer-link">ร้านค้าสหกรณ์</a></li>
                            <li><a href="#" class="footer-link">ตำแหน่งสาขา</a></li>
                            <li><a href="#" class="footer-link">ข่าวสารประชาสัมพันธ์</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-slate-400">
                    <p>&copy; {{ new Date().getFullYear() }} CMU Cooperative. All Rights Reserved.</p>
                    <div class="mt-4 md:mt-0 space-x-6">
                        <a href="#" class="hover:text-slate-600 transition-colors">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
    .font-sans { font-family: 'Prompt', sans-serif; }
    .social-btn { @apply w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110 hover:shadow-md; }
    .footer-link { @apply flex items-center text-slate-500 hover:text-blue-600 transition-colors hover:pl-1 duration-200; }
    .footer-link::before { content: "•"; @apply mr-2 text-slate-300; }
</style>
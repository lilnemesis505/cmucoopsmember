<script setup>
// AppLayout.vue
</script>

<template>
    <div class="min-h-screen flex flex-col font-sans antialiased bg-slate-900 text-slate-200 selection:bg-blue-500 selection:text-white">
        
        <main class="relative z-10">
            <slot />
        </main>

        <footer class="relative w-full bg-white/95 backdrop-blur border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4">

        <!-- TOP CONTENT -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-1">

            <!-- BRAND -->
            <div class="md:col-span-4 lg:col-span-5">
                <div class="mb-2">
                    <h5 class="font-semibold text-slate-900 text-xl mb-1">
                        ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด
                    </h5>
                    <p class="text-slate-500 text-sm">
                        Chiang Mai University Cooperative Store Co., Ltd.
                    </p>
                </div>
                <p class="text-black leading-relaxed mb-6 max-w-sm text-sm">
                    ศูนย์กลางการเชื่อมต่อสมาชิกสหกรณ์ ส่งเสริมการออม
                    การเรียนรู้ตลอดชีวิต และสวัสดิการเพื่อความมั่นคง
                </p>
                <li>
                    <a href="https://www.facebook.com/cmucoopfan"
                        target="_blank"
                        class="text-slate-900 leading-relaxed mb-1 max-w-sm text-sm no-underline hover:text-blue-600 transition-all duration-200 hover:scale-105 flex items-center gap-2">
                        <i class="bi bi-facebook text-base text-[#1877F2]"></i>
                        <span>ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด</span>
                    </a>
                </li>
               <li>
                    <a href="https://www.facebook.com/profile.php?id=61582882842126"
                        target="_blank"
                        class="text-slate-900 leading-relaxed mb-1 max-w-sm text-sm no-underline hover:text-blue-600 transition-all duration-200 hover:scale-105 flex items-center gap-2">
                        <i class="bi bi-facebook text-base text-[#1877F2]"></i>
                        <span>Cmucoop X-cademy</span>
                    </a>
                </li>
                <li>
                    <a class="text-slate-900 leading-relaxed mb-1 max-w-sm text-sm no-underline transition-all duration-200  flex items-center gap-2">
                        <i class="bi bi-line text-base text-[#2baf2b]"></i>
                        <span>ID line : Cmucoop</span>
                    </a>
                </li>
            </div>

            <!-- CONTACT -->
            <div class="md:col-span-4 lg:col-span-4">
                <h6 class="font-semibold text-slate-900 mb-3 text-xl">
                    ติดต่อสอบถาม
                </h6>

                <ul class="space-y-4 text-slate-200 text-sm">
                    <li class="flex items-start">
                        <i class="bi bi-geo-alt-fill text-red-700 mt-1 mr-3"></i>
                        <span class="font-medium text-black">
                            สำนักงานใหญ่ (สนญ.) มหาวิทยาลัยเชียงใหม่<br>
                            239 ถ.ห้วยแก้ว ต.สุเทพ อ.เมืองเชียงใหม่ จ.เชียงใหม่ 50200<br>
                            ติดต่อสอบถามที่บูธสมาชิกสัมพันธ์<br>
                            จันทร์ - ศูกร์ เวลา 9.00 น. - 16.00 น.
                        </span>
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-telephone-fill text-blue-500 mr-3"></i>
                        <span class="font-medium text-black">
                            053-217-139
                        </span>
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-telephone-fill text-blue-500 mr-3"></i>
                        <span class="font-medium text-black">
                            063-138-5154
                        </span>
                    </li>
                </ul>
            </div>

            <!-- LINKS -->
            <div class="md:col-span-4 lg:col-span-3">
                <h6 class="font-semibold text-slate-900 mb-3 text-xl">
                    ลิงค์ที่เกี่ยวข้อง
                </h6>

                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="https://www.cmu-coops.com"
                        target="_blank"
                        class="no-underline text-slate-900 hover:text-blue-600 transition-colors uration-200 hover:scale-105 inline-block">
                        - ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด</a>
                    </li>
                    <li>
                        <a href="https://www.cmu-coops.com/location.php"
                        target="_blank"
                        class="no-underline text-slate-900 hover:text-blue-600 transition-colors uration-200 hover:scale-105 inline-block">- ตำแหน่งที่ตั้งแต่ละสาขา</a>
                    </li>
                    <li>
                        <a href="https://www.cmu-coops.com/coopnews.php" 
                        target="_blank"
                        class="no-underline text-slate-900 hover:text-blue-600 transition-colors uration-200 hover:scale-105 inline-block">- ข่าวสารประชาสัมพันธ์</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- BOTTOM BAR -->
        <div class="border-t border-slate-200 pt-6
                    flex flex-col md:flex-row
                    justify-between items-center
                    text-xs text-slate-500">

            <p>
                © {{ new Date().getFullYear() }} CMU Cooperative.
                All Rights Reserved.
            </p>

            <div class="mt-3 md:mt-0">
                <a href="#" class="hover:text-slate-800 transition-colors">
                    Privacy Policy
                </a>
            </div>
        </div>
    </div>
</footer>
    </div>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
    .font-sans { font-family: 'Prompt', sans-serif; }
    
    .social-btn { 
        @apply w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110; 
    }
    
    /* ปรับสี Link เวลา Hover ให้สว่างขึ้น */
    .footer-link { 
        @apply flex items-center text-slate-400 hover:text-blue-300 transition-colors hover:pl-1 duration-200; 
    }
    
    .footer-link::before { 
        content: "•"; 
        @apply mr-2 text-slate-600; 
    }


.footer-link {
    @apply text-slate-500 hover:text-blue-600
           transition-colors;
}
</style>
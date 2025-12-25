<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayoutXcademy from '@/Layouts/AppLayoutXcademy.vue';

// --- Import Swiper ---
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Grid, Autoplay } from 'swiper/modules';

// --- Import Swiper Styles ---
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';

// --- Props ---
const props = defineProps({
    events: Array,
    sliders: Array,
    staticBanner: Object
});

// --- Modules Configuration ---
const eventModules = [Navigation, Pagination, Grid];
const bannerModules = [Pagination, Autoplay];

// --- Sorting Logic (เรียงตามตัวเลขใน Key จากมากไปน้อย) ---
const sortedEvents = computed(() => {
    if (!props.events) return [];
    return [...props.events].sort((a, b) => {
        const numA = parseInt(a.key.replace(/\D/g, '')) || 0;
        const numB = parseInt(b.key.replace(/\D/g, '')) || 0;
        return numB - numA;
    });
});

// --- Breakpoints for Event Grid ---
const breakpoints = {
    320: { slidesPerView: 1, grid: { rows: 1 }, spaceBetween: 10 },
    640: { slidesPerView: 2, grid: { rows: 2, fill: 'row' }, spaceBetween: 15 },
    1024: { slidesPerView: 3, grid: { rows: 2, fill: 'row' }, spaceBetween: 20 },
};

// --- Modal Logic ---
const isModalOpen = ref(false);
const currentEvent = ref(null);
const currentImageIndex = ref(0);

const openModal = (event) => {
    currentEvent.value = event;
    currentImageIndex.value = 0;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden'; // Lock scroll
};

const closeModal = () => {
    isModalOpen.value = false;
    currentEvent.value = null;
    document.body.style.overflow = ''; // Unlock scroll
};

const nextImage = () => {
    if (currentEvent.value?.images?.length) {
        currentImageIndex.value = (currentImageIndex.value + 1) % currentEvent.value.images.length;
    }
};

const prevImage = () => {
    if (currentEvent.value?.images?.length) {
        currentImageIndex.value = (currentImageIndex.value - 1 + currentEvent.value.images.length) % currentEvent.value.images.length;
    }
};
</script>

<template>
    <AppLayoutXcademy>
        <Head title="X-Cademy กิจกรรมและหลักสูตร" />

        <div class="relative w-full min-h-[calc(100vh-80px)] flex flex-col items-center p-4 md:p-8 font-sans overflow-hidden bg-slate-50">
            
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="animated-shape circle shape-1 bg-purple-500/10 blur-3xl"></div>
                <div class="animated-shape square shape-2 bg-blue-500/10 blur-3xl"></div>
            </div>

 <div class="relative z-10 w-full max-w-7xl mx-auto mb-12 animate-fade-in-down">
    
    <div class="flex flex-col md:flex-row gap-4 w-full md:items-stretch">

        <div class="w-full md:w-[70%] 
                    aspect-[16/9] 
                    rounded-2xl overflow-hidden 
                    shadow-xl border-4 border-white/50 bg-white">
            <swiper
                :modules="bannerModules"
                :slides-per-view="1"
                :loop="true"
                :autoplay="{ delay: 8000, disableOnInteraction: false }"
                :pagination="{ clickable: true }"
                class="w-full h-full"
            >
                <swiper-slide v-for="slide in sliders" :key="slide.id" class="w-full h-full">
                    <img
                        :src="slide.image_url"
                        alt="Slider Image"
                        class="w-full h-full object-cover block"
                    >
                </swiper-slide>
                
                <swiper-slide v-if="!sliders || sliders.length === 0" class="w-full h-full">
                    <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                         No Slider
                    </div>
                </swiper-slide>
            </swiper>
        </div>

        <div class="w-full md:w-[30%] 
                    h-[300px] md:h-auto 
                    rounded-2xl overflow-hidden 
                    shadow-xl border-4 border-white/50 bg-white relative">
            
            <img
                v-if="staticBanner"
                :src="staticBanner.image_url"
                alt="Static Banner"
                class="absolute inset-0 w-full h-full object-cover block"
            >

            <div
                v-else
                class="absolute inset-0 w-full h-full flex items-center justify-center bg-slate-100 text-slate-400"
            >
                Static Image
            </div>
        </div>

    </div>
</div>
            <div class="relative z-10 w-full max-w-7xl mb-8 flex items-center gap-4 animate-fade-in-up px-4">
                 <div class="flex-grow h-px bg-slate-200"></div>
                 <h2 class="text-xl md:text-2xl font-bold text-slate-700 flex items-center whitespace-nowrap">
                     <i class="bi bi-grid-fill text-purple-500 mr-3"></i> กิจกรรมและข่าวสาร
                 </h2>
                 <div class="flex-grow h-px bg-slate-200"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl animate-fade-in-up delay-200">
                <swiper
                    :modules="eventModules"
                    :slides-per-view="3"
                    :grid="{ rows: 2, fill: 'row' }"
                    :space-between="20"
                    :breakpoints="breakpoints"
                    :navigation="true"
                    :pagination="{ clickable: true, dynamicBullets: true }"
                    class="pb-12 !px-2 h-[600px] md:h-[680px]" 
                >
                    <swiper-slide v-for="ev in sortedEvents" :key="ev.id" class="h-[calc((100%-20px)/2)]">
                        <div class="group relative bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer h-full select-none flex flex-col"
                             @click="openModal(ev)">
                            
                            <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100 relative shrink-0">
                                <img v-if="ev.images && ev.images.length > 0"
                                     :src="ev.images[0].image_url + '?tr=w-400,h-300'"
                                     :alt="ev.title"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="bi bi-image text-3xl"></i>
                                </div>

                                <div class="absolute top-2 right-2 z-20 p-1.5 bg-black/30 group-hover:bg-purple-500 text-white rounded-full backdrop-blur-sm transition-all shadow-sm hover:scale-110">
                                    <i class="bi bi-arrows-angle-expand text-xs md:text-sm flex"></i>
                                </div>

                                <div v-if="ev.images && ev.images.length > 0" class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] font-bold px-2 py-0.5 rounded-full backdrop-blur-sm z-10">
                                    <i class="bi bi-images mr-1"></i> {{ ev.images.length }}
                                </div>
                            </div>

                            <div class="p-3 flex flex-col flex-grow relative">
                                <div class="mb-1 text-[10px] text-slate-400 flex items-center">
                                    <i class="bi bi-calendar3 mr-1"></i> {{ ev.event_date || 'ไม่ระบุวันที่' }}
                                </div>
                                <h3 class="text-sm font-bold text-slate-800 mb-1 line-clamp-1 group-hover:text-purple-600 transition-colors leading-snug pr-4" :title="ev.title">
                                    {{ ev.title || 'กิจกรรม (ไม่มีชื่อ)' }}
                                </h3>
                                <div class="mt-auto pt-2 border-t border-slate-100 flex justify-between items-center text-slate-400 group-hover:text-purple-500 transition-colors">
                                    <span class="text-[10px]">แตะเพื่อเปิดดู</span>
                                    <i class="bi bi-box-arrow-up-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>

        <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" @click="closeModal"></div>

            <div class="relative w-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row max-h-[90vh] animate-zoom-in">
                
                <button @click="closeModal" class="absolute top-3 right-3 z-50 p-2 bg-black/40 hover:bg-black/60 rounded-full text-white lg:hidden transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="w-full lg:w-2/3 bg-black flex flex-col relative group h-[40vh] lg:h-auto border-r border-slate-800">
                     <div class="flex-grow relative flex items-center justify-center bg-zinc-900 overflow-hidden">
                         <div v-if="currentEvent.images && currentEvent.images.length > 0" class="w-full h-full flex items-center justify-center">
                             <img :src="currentEvent.images[currentImageIndex].image_url" 
                                  class="max-w-full max-h-full object-contain transition-all duration-300">
                             
                             <button v-if="currentEvent.images.length > 1" @click.stop="prevImage" class="absolute left-4 p-3 rounded-full bg-white/10 hover:bg-white/30 text-white transition-all hover:scale-110">
                                 <i class="bi bi-chevron-left text-xl"></i>
                             </button>
                             <button v-if="currentEvent.images.length > 1" @click.stop="nextImage" class="absolute right-4 p-3 rounded-full bg-white/10 hover:bg-white/30 text-white transition-all hover:scale-110">
                                 <i class="bi bi-chevron-right text-xl"></i>
                             </button>
                         </div>
                         <div v-else class="text-white/50 flex flex-col items-center">
                             <i class="bi bi-image-slash text-4xl mb-2"></i>
                             <span>ไม่มีรูปภาพในอัลบั้มนี้</span>
                         </div>
                     </div>
                     
                     <div v-if="currentEvent.images && currentEvent.images.length > 1" 
                          class="h-20 bg-zinc-950 border-t border-white/10 flex items-center gap-2 px-4 overflow-x-auto no-scrollbar py-2 shrink-0">
                         <div v-for="(img, idx) in currentEvent.images" :key="img.id"
                              @click.stop="currentImageIndex = idx"
                              :class="['h-full aspect-[4/3] rounded overflow-hidden cursor-pointer border-2 transition-all shrink-0', 
                                       currentImageIndex === idx ? 'border-purple-500 opacity-100' : 'border-transparent opacity-40 hover:opacity-100']">
                             <img :src="img.image_url + '?tr=w-100,h-80'" class="w-full h-full object-cover">
                         </div>
                     </div>
                </div>

                <div class="w-full lg:w-1/3 bg-white flex flex-col h-[50vh] lg:h-auto border-l border-slate-100">
                     <div class="p-6 border-b border-slate-100 flex justify-between items-start bg-white z-10 shadow-sm">
                         <div class="w-full">
                            <div class="flex justify-between items-start w-full">
                                <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-md mb-2 inline-block tracking-wider">
                                    {{ currentEvent.key.toUpperCase() }}
                                </span>
                                <button @click="closeModal" class="hidden lg:block text-slate-300 hover:text-red-500 transition-colors p-1">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>
                            <h2 class="text-xl md:text-2xl font-bold text-slate-800 leading-snug mb-2">
                                {{ currentEvent.title || 'ไม่มีหัวข้อ' }}
                            </h2>
                            <p class="text-sm text-slate-500 flex items-center gap-2">
                                <i class="bi bi-calendar3 text-purple-400"></i> 
                                {{ currentEvent.event_date || 'ไม่ระบุวันที่' }}
                            </p>
                         </div>
                     </div>

                     <div class="flex-grow overflow-y-auto p-6 bg-slate-50/50 custom-scrollbar">
                         <div v-if="currentEvent.description" class="prose prose-sm prose-slate max-w-none">
                             <p class="whitespace-pre-line text-slate-600 leading-relaxed text-base">
                                 {{ currentEvent.description }}
                             </p>
                         </div>
                         <div v-else class="text-center py-10 text-slate-400 italic">
                             ไม่มีรายละเอียดเพิ่มเติม
                         </div>
                     </div>
                     
                     <div class="p-4 border-t border-slate-100 bg-white text-xs text-center text-slate-400 shrink-0">
                         <span v-if="currentEvent.images?.length > 0">
                             รูปภาพที่ {{ currentImageIndex + 1 }} จาก {{ currentEvent.images.length }}
                         </span>
                         <span v-else>News & Activity</span>
                     </div>
                </div>

            </div>
        </div>

    </AppLayoutXcademy>
</template>

<style scoped>
/* Swiper Customization */
:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    color: #ea42d9;
    background: rgba(255, 255, 255, 0.9);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
:deep(.swiper-button-next):after,
:deep(.swiper-button-prev):after {
    font-size: 16px;
    font-weight: bold;
}
:deep(.swiper-pagination-bullet-active) {
    background: #cc50e2;
}

/* Background Animation */
.animated-shape {
    position: absolute;
    opacity: 0.6;
    animation: float 20s infinite ease-in-out alternate;
}
@keyframes float {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(50px, 30px) scale(1.1); }
}
.shape-1 { width: 400px; height: 400px; top: -10%; left: -10%; animation-delay: 0s; }
.shape-2 { width: 300px; height: 300px; bottom: 10%; right: -5%; animation-delay: 2s; transform: rotate(45deg); }

.animate-fade-in-down { animation: fadeInDown 0.8s ease-out; }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

.animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

/* Modal Zoom Animation */
.animate-zoom-in { animation: zoomIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

.delay-200 { animation-delay: 0.2s; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Custom Scrollbar for Text Area */
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayoutXcademy from '@/Layouts/AppLayoutXcademy.vue';
import { ref, computed } from 'vue'; // เพิ่ม computed

// --- Import Swiper Vue.js components ---
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Grid } from 'swiper/modules'; // ลบ Autoplay ออก

// --- Import Swiper styles ---
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';

const props = defineProps({
    events: Array
});

// --- Sorting Logic (ใหม่) ---
// เรียงลำดับจาก ev มากไปหา ev น้อย (กิจกรรมล่าสุดขึ้นก่อน)
const sortedEvents = computed(() => {
    if (!props.events) return [];
    return [...props.events].sort((a, b) => {
        // ดึงตัวเลขออกจาก key เช่น 'ev10' -> 10
        const numA = parseInt(a.key.replace(/\D/g, '')) || 0;
        const numB = parseInt(b.key.replace(/\D/g, '')) || 0;
        return numB - numA; // เรียงจากมากไปน้อย (Descending)
    });
});

// --- Swiper Configuration ---
const modules = [Navigation, Pagination, Grid]; // ลบ Autoplay ออกจาก modules

// ตั้งค่า Responsive: จอใหญ่ให้โชว์ 3 คอลัมน์ x 2 แถว = 6 รูป
const breakpoints = {
    320: { 
        slidesPerView: 1, 
        grid: { rows: 1 }, 
        spaceBetween: 10 
    }, 
    640: { 
        slidesPerView: 2, 
        grid: { rows: 2, fill: 'row' }, 
        spaceBetween: 15 
    },
    1024: { 
        slidesPerView: 3, 
        grid: { rows: 2, fill: 'row' }, 
        spaceBetween: 20 
    }, 
};

// --- Lightbox Logic ---
const isLightboxOpen = ref(false);
const currentEvent = ref(null);
const currentImageIndex = ref(0);

const openLightbox = (event) => {
    if (event.images && event.images.length > 0) {
        currentEvent.value = event;
        currentImageIndex.value = 0;
        isLightboxOpen.value = true;
        document.body.style.overflow = 'hidden';
    }
};

const closeLightbox = () => {
    isLightboxOpen.value = false;
    currentEvent.value = null;
    document.body.style.overflow = '';
};

const nextImage = () => {
    if (currentEvent.value && currentImageIndex.value < currentEvent.value.images.length - 1) {
        currentImageIndex.value++;
    } else {
        currentImageIndex.value = 0;
    }
};

const prevImage = () => {
    if (currentEvent.value && currentImageIndex.value > 0) {
        currentImageIndex.value--;
    } else {
        currentImageIndex.value = currentEvent.value.images.length - 1;
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

            <div class="relative z-10 w-full max-w-6xl mt-4 mb-12 animate-fade-in-down text-center flex flex-col items-center justify-center">
                
                <div class="mb-6 relative">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-slate-800 tracking-tight drop-shadow-sm">
                        กิจกรรมประจำเดือน
                    </h1>
                </div>

                <div class="relative group cursor-pointer transition-transform hover:scale-[1.01] duration-500">
                    <div class="absolute -inset-4 bg-gradient-to-r from-purple-100 via-amber-100 to-purple-100 rounded-[2rem] blur-3xl opacity-60 group-hover:opacity-80 transition-opacity"></div>
                    
                    <img 
                        src="https://ik.imagekit.io/cmucoopsmember/S__20848677.jpg" 
                        alt="Poster Activity" 
                        class="relative w-auto h-[350px] md:h-[550px] object-contain drop-shadow-2xl z-10 rounded-2xl border-4 border-white/50"
                    >
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
                    :modules="modules"
                    :slides-per-view="3"
                    :grid="{ rows: 2, fill: 'row' }"
                    :space-between="20"
                    :breakpoints="breakpoints"
                    :navigation="true"
                    :pagination="{ clickable: true, dynamicBullets: true }"
                    class="pb-12 !px-2 h-[600px] md:h-[550px]" 
                >
                    <swiper-slide v-for="ev in sortedEvents" :key="ev.id" class="h-[calc((100%-20px)/2)]"> 
                        <div class="group relative bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer h-full select-none flex flex-col"
                             @click="openLightbox(ev)">
                            
                            <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100 relative shrink-0">
                                <img v-if="ev.images && ev.images.length > 0" 
                                     :src="ev.images[0].image_url + '?tr=w-400,h-300'" 
                                     :alt="ev.title" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="bi bi-image text-3xl"></i>
                                </div>
                                
                                <div v-if="ev.images && ev.images.length > 0" class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] font-bold px-2 py-0.5 rounded-full backdrop-blur-sm">
                                    <i class="bi bi-images mr-1"></i> {{ ev.images.length }}
                                </div>
                            </div>

                            <div class="p-3 flex flex-col flex-grow">
                                <div class="mb-1 text-[10px] text-slate-400 flex items-center">
                                    <i class="bi bi-calendar3 mr-1"></i> {{ ev.event_date || 'ไม่ระบุวันที่' }}
                                </div>
                                
                                <h3 class="text-sm font-bold text-slate-800 mb-1 line-clamp-2 group-hover:text-purple-600 transition-colors leading-snug">
                                    {{ ev.title || 'กิจกรรม' }}
                                </h3>
                                
                                <div class="mt-auto pt-2 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-[10px] text-slate-400 group-hover:text-purple-500 transition-colors">ดูรูปภาพ</span>
                                    <i class="bi bi-chevron-right text-xs text-slate-300 group-hover:text-purple-500 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>

                    </swiper-slide>
                </swiper>

            </div>
        </div>

        <div v-if="isLightboxOpen" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl flex items-center justify-center">
            <button @click.stop="closeLightbox" class="absolute top-4 right-4 text-white/70 hover:text-white p-2 z-50 transition-transform hover:rotate-90">
                <i class="bi bi-x-lg text-3xl"></i>
            </button>

            <button v-if="currentEvent.images.length > 1" @click.stop="prevImage" class="absolute left-4 text-white/50 hover:text-white p-4 z-50 hover:bg-white/10 rounded-full transition-all">
                <i class="bi bi-chevron-left text-4xl"></i>
            </button>
            <button v-if="currentEvent.images.length > 1" @click.stop="nextImage" class="absolute right-4 text-white/50 hover:text-white p-4 z-50 hover:bg-white/10 rounded-full transition-all">
                <i class="bi bi-chevron-right text-4xl"></i>
            </button>

            <div class="w-full h-full p-4 md:p-10 flex flex-col items-center justify-center">
                <div class="relative max-w-full max-h-[85vh]">
                    <img :src="currentEvent.images[currentImageIndex].image_url" 
                         class="max-w-full max-h-[80vh] object-contain shadow-2xl rounded-lg border border-white/10">
                    
                    <div class="text-center mt-4 text-white">
                        <h3 class="text-xl font-bold">{{ currentEvent.title }}</h3>
                        <p class="text-sm text-slate-400">รูปที่ {{ currentImageIndex + 1 }} / {{ currentEvent.images.length }}</p>
                    </div>
                </div>
            </div>
            
            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4 overflow-x-auto no-scrollbar">
                <div v-for="(img, idx) in currentEvent.images" :key="img.id"
                     @click.stop="currentImageIndex = idx"
                     :class="['w-16 h-16 flex-shrink-0 rounded-md overflow-hidden cursor-pointer border-2 transition-all', 
                              currentImageIndex === idx ? 'border-purple-500 opacity-100 scale-110' : 'border-transparent opacity-50 hover:opacity-100']">
                    <img :src="img.image_url" class="w-full h-full object-cover">
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

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.delay-200 { animation-delay: 0.2s; }
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
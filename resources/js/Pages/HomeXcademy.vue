<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3'; // เพิ่ม Link
import AppLayoutXcademy from '@/Layouts/AppLayoutXcademy.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Grid, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';

const props = defineProps({
    events: Array,
    sliders: Array,
    staticBanner: Object
});

const eventModules = [Navigation, Pagination, Grid];
const bannerModules = [Pagination, Autoplay];

const sortedEvents = computed(() => {
    if (!props.events) return [];
    return [...props.events].sort((a, b) => {
        const numA = parseInt(a.key.replace(/\D/g, '')) || 0;
        const numB = parseInt(b.key.replace(/\D/g, '')) || 0;
        return numB - numA;
    });
});

const breakpoints = {
    320: { slidesPerView: 1, grid: { rows: 1 }, spaceBetween: 10 },
    640: { slidesPerView: 2, grid: { rows: 2, fill: 'row' }, spaceBetween: 15 },
    1024: { slidesPerView: 3, grid: { rows: 2, fill: 'row' }, spaceBetween: 20 },
};

// --- Static Banner Lightbox Logic ---
const showStaticLightbox = ref(false);
</script>

<template>
    <AppLayoutXcademy>
        <Head title="ข่าวสารและกิจกกรม X-Cademy" />

        <div class="relative w-full flex flex-col items-center p-4 md:p-8 font-sans overflow-hidden bg-slate-50 min-h-screen">
            
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="animated-shape circle shape-1 bg-purple-500/10 blur-3xl"></div>
                <div class="animated-shape square shape-2 bg-blue-500/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto mb-8 animate-fade-in-down">
                <div class="flex flex-col md:flex-row gap-4 w-full md:items-stretch">

                    <div class="w-full md:w-[70%] aspect-[16/9] rounded-2xl overflow-hidden shadow-xl border-4 border-white/50 bg-white">
                        <swiper :modules="bannerModules" :slides-per-view="1" :loop="true" :autoplay="{ delay: 8000 }" :pagination="{ clickable: true }" class="w-full h-full">
                            <swiper-slide v-for="slide in sliders" :key="slide.id" class="w-full h-full">
                                <img :src="slide.image_url" class="w-full h-full object-cover block">
                            </swiper-slide>
                            <swiper-slide v-if="!sliders?.length" class="w-full h-full">
                                <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">No Slider</div>
                            </swiper-slide>
                        </swiper>
                    </div>

                    <div class="w-full md:w-[30%] aspect-[16/9] md:aspect-auto md:h-auto rounded-2xl overflow-hidden shadow-xl border-4 border-white/50 bg-white relative group cursor-pointer"
                         @click="staticBanner ? showStaticLightbox = true : null">
                        
                        <img v-if="staticBanner" :src="staticBanner.image_url" class="absolute inset-0 w-full h-full object-cover block transition-transform duration-500 group-hover:scale-105">
                        
                        <div v-if="staticBanner" class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                            <i class="bi bi-arrows-fullscreen text-white opacity-0 group-hover:opacity-100 text-3xl drop-shadow-md transition-opacity"></i>
                        </div>

                        <div v-else class="absolute inset-0 w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                            Static Image
                        </div>
                    </div>

                </div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mb-6 flex items-center gap-4 animate-fade-in-up px-4">
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
    class="pb-12 !px-2 h-[420px] md:h-[750px]"
>
                    <swiper-slide v-for="ev in sortedEvents" :key="ev.id" class="h-[calc((100%-20px)/2)]">
                        
                       <Link :href="route('xcademy.event', ev.key)" class="block h-full">
    <div class="group relative bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer h-full select-none flex flex-col">
        
        <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100 relative shrink-0">
            <img v-if="ev.images && ev.images.length > 0" :src="ev.images[0].image_url + '?tr=w-400,h-300'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div v-else class="w-full h-full flex items-center justify-center text-slate-300"><i class="bi bi-image text-3xl"></i></div>
        </div>

        <div class="p-4 flex flex-col flex-grow relative"> <div class="mb-2 text-[11px] font-medium text-purple-600 flex items-center bg-purple-50 self-start px-2 py-0.5 rounded-full">
                <i class="bi bi-calendar3 mr-1"></i> {{ ev.event_date || 'ไม่ระบุวันที่' }}
            </div>
            
            <h3 class="text-sm font-bold text-slate-800 mb-1 group-hover:text-purple-600 transition-colors leading-relaxed line-clamp-3">
                {{ ev.title || 'กิจกรรม (ไม่มีชื่อ)' }}
            </h3>
        </div>
    </div>
</Link>

                    </swiper-slide>
                </swiper>
            </div>
        </div>

        <Teleport to="body">
            <div v-if="showStaticLightbox && staticBanner" class="fixed inset-0 z-[9999] bg-black/95 flex items-center justify-center p-4 backdrop-blur-sm animate-zoom-in" @click="showStaticLightbox = false">
                <button class="absolute top-4 right-4 text-white hover:text-red-500 transition-colors p-2 z-50">
                    <i class="bi bi-x-lg text-3xl"></i>
                </button>
                <img :src="staticBanner.image_url" class="max-w-full max-h-[95vh] object-contain rounded-lg shadow-2xl" @click.stop>
            </div>
        </Teleport>

    </AppLayoutXcademy>
</template>

<style scoped>
:deep(.swiper-button-next), :deep(.swiper-button-prev) { color: #ea42d9; background: rgba(255,255,255,0.9); width: 36px; height: 36px; border-radius: 50%; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
:deep(.swiper-button-next):after, :deep(.swiper-button-prev):after { font-size: 16px; font-weight: bold; }
:deep(.swiper-pagination-bullet-active) { background: #cc50e2; }

.animated-shape { position: absolute; opacity: 0.6; animation: float 20s infinite ease-in-out alternate; }
@keyframes float { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(50px, 30px) scale(1.1); } }
.shape-1 { width: 400px; height: 400px; top: -10%; left: -10%; animation-delay: 0s; }
.shape-2 { width: 300px; height: 300px; bottom: 10%; right: -5%; animation-delay: 2s; transform: rotate(45deg); }

.animate-fade-in-down { animation: fadeInDown 0.8s ease-out; }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-zoom-in { animation: zoomIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes zoomIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
.delay-200 { animation-delay: 0.2s; }
</style>
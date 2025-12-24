<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayoutXcademy from '@/Layouts/AppLayoutXcademy.vue';
import { ref } from 'vue';

const props = defineProps({
    events: Array
});

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
                <div class="animated-shape circle shape-1 bg-orange-500/10 blur-3xl"></div>
                <div class="animated-shape square shape-2 bg-blue-500/10 blur-3xl"></div>
                <div class="animated-shape circle shape-3 bg-purple-500/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 w-full max-w-6xl mt-8 mb-12 animate-fade-in-down text-center flex flex-col items-center justify-center">
                
                <div class="mb-8 relative">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 tracking-tight drop-shadow-sm">
                        กิจกรรมประจำเดือน
                    </h1>
                </div>

                <div class="relative group cursor-pointer transition-transform hover:scale-[1.01] duration-500">
                    <div class="absolute -inset-4 bg-gradient-to-r from-orange-100 via-amber-100 to-purple-100 rounded-[2rem] blur-3xl opacity-60 group-hover:opacity-80 transition-opacity"></div>
                    
                    <img 
                        src="https://ik.imagekit.io/cmucoopsmember/S__20848677.jpg" 
                        alt="Poster Activity" 
                        class="relative w-auto h-[450px] md:h-[650px] object-contain drop-shadow-2xl z-10 rounded-2xl border-4 border-white/50"
                    >
                </div>
            </div>


            <div class="relative z-10 w-full max-w-7xl mt-8 mb-8 flex items-center gap-4 animate-fade-in-up px-4">
                 <div class="flex-grow h-px bg-slate-200"></div>
                 <h2 class="text-2xl md:text-3xl font-bold text-slate-700 flex items-center whitespace-nowrap">
                     <i class="bi bi-grid-fill text-purple-500 mr-3"></i> อัลบั้มภาพกิจกรรม
                 </h2>
                 <div class="flex-grow h-px bg-slate-200"></div>
            </div>


            <div class="relative z-10 w-full max-w-7xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-20 animate-fade-in-up delay-200">
                
                <div v-for="ev in events" :key="ev.id" 
                     class="group relative bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:-translate-y-2 hover:shadow-xl transition-all duration-300 cursor-pointer flex flex-col h-full"
                     @click="openLightbox(ev)">
                    
                    <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                        <img v-if="ev.images && ev.images.length > 0" 
                             :src="ev.images[0].image_url" 
                             :alt="ev.title" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="bi bi-image text-4xl"></i>
                        </div>
                        
                        <div v-if="ev.images && ev.images.length > 0" class="absolute bottom-3 right-3 bg-white/90 text-slate-700 text-xs font-bold px-2 py-1 rounded-md shadow-sm backdrop-blur-sm border border-slate-100">
                            <i class="bi bi-collection-fill mr-1 text-orange-500"></i> {{ ev.images.length }} รูป
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-orange-600 border border-orange-200 bg-orange-50 px-2 py-1 rounded">
                                {{ ev.key.toUpperCase() }}
                            </span>
                            <span v-if="ev.event_date" class="text-xs text-slate-400 flex items-center">
                                <i class="bi bi-calendar3 mr-1"></i> {{ ev.event_date }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            {{ ev.title || 'กิจกรรม (ยังไม่มีชื่อ)' }}
                        </h3>
                        
                        <p class="text-slate-500 text-sm font-light line-clamp-3 mb-4 flex-grow">
                            {{ ev.description || 'ไม่มีรายละเอียด' }}
                        </p>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-sm text-slate-400 group-hover:text-orange-600 transition-colors">
                            <span>ดูภาพกิจกรรม</span>
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </div>

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
                              currentImageIndex === idx ? 'border-orange-500 opacity-100 scale-110' : 'border-transparent opacity-50 hover:opacity-100']">
                    <img :src="img.image_url" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

    </AppLayoutXcademy>
</template>

<style scoped>
/* Animation Background */
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
.shape-3 { width: 350px; height: 350px; top: 40%; left: 40%; animation-delay: 4s; }

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
.delay-200 {
    animation-delay: 0.2s;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
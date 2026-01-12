<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayoutXcademy from '@/Layouts/AppLayoutXcademy.vue';

const props = defineProps({
    event: Object
});

// --- Lightbox Logic ---
const isLightboxOpen = ref(false);
const currentImageIndex = ref(0);

const openLightbox = (index) => {
    currentImageIndex.value = index;
    isLightboxOpen.value = true;
    document.body.style.overflow = 'hidden'; // ล็อคสกรอลล์
};

const closeLightbox = () => {
    isLightboxOpen.value = false;
    document.body.style.overflow = '';
};

const nextImage = () => {
    if (props.event?.images?.length) {
        currentImageIndex.value = (currentImageIndex.value + 1) % props.event.images.length;
    }
};

const prevImage = () => {
    if (props.event?.images?.length) {
        currentImageIndex.value = (currentImageIndex.value - 1 + props.event.images.length) % props.event.images.length;
    }
};

// ฟังก์ชันช่วยดึง URL ไม่ว่าข้อมูลจะมาเป็น String หรือ Object
const getImgUrl = (img) => {
    return img.image_url || img; 
};
</script>

<template>
    <AppLayoutXcademy>
        <Head :title="event.title" />

        <div class="min-h-screen bg-slate-50 py-10 px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="p-8 md:p-12">
                    <div class="mb-6 flex items-center gap-2 text-sm">
                        <Link :href="route('xcademy')" class="text-slate-500 hover:text-purple-600 font-bold transition-colors flex items-center gap-1">
                            <i class="bi bi-chevron-left"></i> กิจกรรมทั้งหมด
                        </Link>
                        <span class="text-slate-300">/</span>
                        <span class="text-purple-600 font-medium bg-purple-50 px-2 py-0.5 rounded text-xs tracking-wider">
                            {{ event.key.toUpperCase() }}
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-4xl font-extrabold text-slate-800 leading-tight mb-4">
                        {{ event.title }}
                    </h1>

                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-8 pb-8 border-b border-slate-100">
                        <i class="bi bi-calendar3 text-purple-500"></i>
                        <span>{{ event.event_date || 'ไม่ระบุวันที่' }}</span>
                    </div>

                    <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed whitespace-pre-line">
                        <p v-if="event.description">{{ event.description }}</p>
                        <p v-else class="text-slate-400 italic text-center py-4">ไม่มีรายละเอียดเนื้อหา</p>
                    </div>
                </div>

                <div class="bg-slate-50 p-8 md:p-12 border-t border-slate-200" v-if="event.images && event.images.length > 0">
                    <h3 class="text-lg font-bold text-slate-700 mb-6 flex items-center gap-2">
                        <i class="bi bi-images text-purple-500"></i> ภาพบรรยากาศ ({{ event.images.length }} รูป)
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div v-for="(img, idx) in event.images" :key="idx" 
                             class="aspect-[4/3] rounded-xl overflow-hidden cursor-pointer group relative shadow-sm hover:shadow-md transition-all bg-white"
                             @click="openLightbox(idx)">
                            
                            <img :src="getImgUrl(img) + '?tr=w-400'" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <i class="bi bi-zoom-in text-white opacity-0 group-hover:opacity-100 text-3xl drop-shadow-md transition-all transform scale-50 group-hover:scale-100"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <Teleport to="body">
            <div v-if="isLightboxOpen" class="fixed inset-0 z-[9999] bg-black/95 flex items-center justify-center backdrop-blur-sm animate-fade-in" @click.self="closeLightbox">
                
                <button @click="closeLightbox" class="absolute top-4 right-4 z-50 p-2 text-white/50 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-3xl"></i>
                </button>

                <button v-if="event.images.length > 1" @click.stop="prevImage" class="absolute left-4 z-50 p-4 text-white/50 hover:text-white transition-colors hover:scale-110">
                    <i class="bi bi-chevron-left text-4xl"></i>
                </button>
                <button v-if="event.images.length > 1" @click.stop="nextImage" class="absolute right-4 z-50 p-4 text-white/50 hover:text-white transition-colors hover:scale-110">
                    <i class="bi bi-chevron-right text-4xl"></i>
                </button>

                <div class="relative max-w-7xl max-h-[90vh] w-full h-full p-4 flex items-center justify-center">
                    <img :src="getImgUrl(event.images[currentImageIndex])" 
                         class="max-w-full max-h-full object-contain shadow-2xl rounded-sm">
                    
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/60 text-white px-4 py-1 rounded-full text-sm backdrop-blur-md">
                        {{ currentImageIndex + 1 }} / {{ event.images.length }}
                    </div>
                </div>

            </div>
        </Teleport>
    </AppLayoutXcademy>
</template>

<style scoped>
.animate-fade-in { animation: fadeIn 0.2s ease-out; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
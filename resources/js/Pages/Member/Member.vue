<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';
import { Modal } from 'bootstrap';

// รับค่า page
const props = defineProps({
    page: Object
});

// ตัวแปรสำหรับ Popup
const popupImageUrl = ref('');
let imageModal = null;

onMounted(() => {
    // เช็คว่ามี Modal Element จริงไหมก่อนเรียกใช้
    const modalElement = document.getElementById('imagePreviewModal');
    if (modalElement) {
        imageModal = new Modal(modalElement);
    }
});

const showImagePopup = (url) => {
    if (!url || !imageModal) return;
    const baseUrl = url.split('?')[0];
    popupImageUrl.value = baseUrl;
    imageModal.show();
};
</script>

<template>
    <AppLayoutMember>
        <Head :title="page?.title || 'สมาชิก'" />

        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            
                            <h1 class="mb-2 text-center text-primary fw-bold">{{ page?.title }}</h1>
                            <h4 v-if="page?.subtitle" class="text-muted text-center mb-4">
                                {{ page.subtitle }}
                            </h4>
                            
                            <hr class="my-4">

                            <div v-if="page?.content" class="content-body" 
                                 style="font-size: 1.1rem; line-height: 1.8;" 
                                 v-html="page.content">
                            </div>

                            <div v-if="page?.images && Array.isArray(page.images) && page.images.length > 0" class="row g-4 mt-4">
                                <div v-for="(img, index) in page.images" :key="index" class="col-md-6">
                                    <img :src="img" 
                                         class="img-fluid rounded shadow-sm w-100 hover-zoom"
                                         style="cursor: zoom-in;"
                                         @click="showImagePopup(img)">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 1055;">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content bg-transparent border-0 shadow-none">
                        <div class="modal-body p-0 text-center position-relative">
                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle" 
                                    data-bs-dismiss="modal" aria-label="Close" style="z-index: 1060;">
                            </button>
                            <img :src="popupImageUrl" class="img-fluid rounded shadow-lg" style="max-height: 90vh; object-fit: contain;">
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

    </AppLayoutMember>
</template>

<style scoped>
.hover-zoom {
    transition: transform 0.3s ease;
}
.hover-zoom:hover {
    transform: scale(1.02);
}
</style>
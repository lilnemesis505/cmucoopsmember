<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';
import { Modal } from 'bootstrap';

const props = defineProps({
    post: Object
});

const popupImageUrl = ref('');
let imageModal = null;

onMounted(() => {
    const el = document.getElementById('imagePreviewModal');
    if (el) imageModal = new Modal(el);
});

const showImagePopup = (url) => {
    if (!url) return;
    popupImageUrl.value = url.split('?')[0];
    imageModal.show();
};
</script>

<template>
    <AppLayoutMember>
        <Head :title="post.title" />

        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <Link :href="route('easypoint')" class="btn btn-light text-muted mb-4 rounded-pill shadow-sm">
                        <i class="bi bi-arrow-left"></i> กลับหน้ารวม
                    </Link>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            
                            <h1 class="mb-2 text-center text-warning fw-bold">{{ post.title }}</h1>
                            <h4 v-if="post.subtitle" class="text-muted text-center mb-4">{{ post.subtitle }}</h4>
                            
                            <hr class="my-4">

                            <div class="content-body" style="font-size: 1.1rem; line-height: 1.8;" v-html="post.content">
                            </div>

                            <div v-if="post.images && post.images.length > 0" class="row g-4 mt-4">
                                <div v-for="(img, index) in post.images" :key="index" class="col-md-6">
                                    <div class="overflow-hidden rounded shadow-sm position-relative group-hover-zoom">
                                        <img :src="img" 
                                             class="img-fluid w-100" 
                                             style="cursor: zoom-in; transition: transform 0.3s ease;"
                                             @click="showImagePopup(img)">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-transparent border-0 shadow-none">
                    <div class="modal-body p-0 text-center position-relative">
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle" 
                                data-bs-dismiss="modal" style="z-index: 1050;"></button>
                        <img :src="popupImageUrl" class="img-fluid rounded shadow-lg" style="max-height: 90vh;">
                    </div>
                </div>
            </div>
        </div>

    </AppLayoutMember>
</template>

<style scoped>
    .group-hover-zoom:hover img { transform: scale(1.03); }
</style>
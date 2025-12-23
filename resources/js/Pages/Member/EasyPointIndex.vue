<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue';

defineProps({
    posts: Array
});
</script>

<template>
    <AppLayoutMember>
        <Head title="Easy Point" />

        <div class="container my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-warning">
                    <i class="bi bi-star-fill"></i> Easy Point สิทธิพิเศษ
                </h2>
                <p class="text-muted">รายการแลกแต้มและสิทธิพิเศษสำหรับสมาชิก</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div v-for="post in posts" :key="post.id" class="col">
                    <Link :href="route('easypoint.show', post.id)" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm hover-card border-0">
                            <div style="height: 200px; overflow: hidden; border-radius: 10px 10px 0 0;" class="bg-light position-relative">
                                <img v-if="post.cover_image" 
                                     :src="`${post.cover_image}?tr=w-400,h-300,c-maintain_ratio`" 
                                     class="w-100 h-100" 
                                     style="object-fit: cover;">
                                
                                <div v-else class="d-flex align-items-center justify-content-center h-100 text-secondary opacity-25">
                                    <i class="bi bi-gift fs-1"></i>
                                </div>
                            </div>

                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bold mb-2">{{ post.title }}</h5>
                                <p class="text-muted small text-truncate">{{ post.subtitle }}</p>
                                <button class="btn btn-outline-warning btn-sm rounded-pill mt-2 px-4">ดูรายละเอียด</button>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            
            <div v-if="posts.length === 0" class="text-center py-5 text-muted">
                กำลังอัปเดตรายการใหม่ เร็วๆ นี้
            </div>
        </div>

    </AppLayoutMember>
</template>

<style scoped>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
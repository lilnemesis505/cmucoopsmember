<script setup>
import { Head, Link } from '@inertiajs/vue3';
// [สำคัญ] เปลี่ยนจาก AppLayout เป็น AppLayoutMember
import AppLayoutMember from '@/Layouts/AppLayoutMember.vue'; 

defineProps({
    cards: Array,
    title: String
});
</script>

<template>
    <AppLayoutMember>
        <Head :title="title" />

        <div class="my-4">
             <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">ยินดีต้อนรับสู่ระบบสมาชิก</h2>
             </div>
             <div class="row g-4">
                <div v-for="card in cards" :key="card.id" class="col-md-4">
                    <Link :href="card.link" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <img :src="card.image_url" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-dark">{{ card.title }}</h5>
                                <p class="card-text text-muted">{{ card.subtitle }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

    </AppLayoutMember>
</template>
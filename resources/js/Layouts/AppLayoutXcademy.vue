<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-white px-3 px-lg-4 border-bottom border-warning border-3">
            <div class="container-fluid">
                <Link class="navbar-brand logo-container" :href="route('landing')">
                    <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="CMU X-CADEMY" class="logo-img">
                </Link>
                
                <div class="ms-auto d-flex align-items-center">
                     <span class="badge bg-warning text-dark me-3">X-CADEMY ZONE</span>
                     <Link class="btn btn-outline-secondary btn-sm rounded-pill" :href="route('landing')">
                        <i class="bi bi-house"></i> กลับหน้าหลัก
                    </Link>
                </div>
            </div>
        </nav>

        <div class="container py-5">
            <slot />
        </div>
    </div>
</template>

<style scoped>
    /* CSS คล้ายๆ เดิม แต่ปรับธีม */
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap');
    .navbar { font-family: 'Prompt', sans-serif; height: 80px; }
    .logo-img { height: 80px; width: auto; }
</style>
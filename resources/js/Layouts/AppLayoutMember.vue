<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-white px-3 px-lg-4">
            <div class="container-fluid">
                
                <Link class="navbar-brand logo-container" :href="route('landing')">
                    <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="CMU X-CADEMY" class="logo-img">
                </Link>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current('member.home') }" :href="route('member.home')">หน้าหลัก</Link>
                        </li>
                        
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current('member') }" :href="route('member')">สมาชิก</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current('board*') }" :href="route('board')">สวัสดิการ</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current('easypoint*') }" :href="route('easypoint')">EasyPoint</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current('check.member') }" :href="route('check.member')">ตรวจสอบสมาชิก</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="padding-top: 30px;">
            <slot />
        </div>

        <footer class="bg-dark text-white pt-4 pb-3 border-top mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-3 fw-bold text-warning border-bottom border-warning d-inline-block pb-1">ติดต่อสอบถาม</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="text-white-50 small me-2">เบอร์โทรศัพท์:</span>
                                <span class="fw-bold">063-1385154, 0-5321-7139</span>
                            </li>
                            <li class="mb-2">
                                <span class="text-white-50 small me-2">Line ID:</span>
                                <a href="https://line.me/R/ti/p/@cmucoop" target="_blank" class="text-white text-decoration-none hover-link">cmucoopmember</a>
                            </li>
                            <li class="mb-2">
                                <span class="text-white-50 small me-2">Line ID:</span>
                                <a href="https://line.me/R/ti/p/@cmucoop" target="_blank" class="text-white text-decoration-none hover-link">cmucoop</a>
                            </li>
                            <li class="mb-2">
                                <span class="text-white-50 small me-2">อีเมล:</span>
                                <a href="mailto:cmucoop@gmail.com" class="text-white text-decoration-none hover-link">cmucoop@gmail.com</a>
                            </li>
                            <li class="mb-2">
                                <span class="text-white-50 small me-2">Facebook:</span>
                                <a href="https://www.facebook.com/share/1AD8Pi4Wf7/" target="_blank" class="text-white text-decoration-none hover-link">CMUcoop X-cademy</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">ลิงก์ที่เกี่ยวข้อง</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="https://www.cmu-coops.com/" target="_blank" class="text-white text-decoration-none small hover-link">
                                    <i class="bi bi-chevron-right small text-muted me-1"></i> ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="https://www.cmu-coops.com/location.php" class="text-white text-decoration-none small hover-link">
                                    <i class="bi bi-chevron-right small text-muted me-1"></i> ตำแหน่งร้านสหกรณ์
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">CMUCOOP'S</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="https://www.cmu-coops.com/about.php" class="text-white text-decoration-none small hover-link">
                                    <i class="bi bi-chevron-right small text-muted me-1"></i> เกี่ยวกับร้านสหกรณ์
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="https://www.cmu-coops.com/coopnews.php" class="text-white text-decoration-none small hover-link">
                                    <i class="bi bi-chevron-right small text-muted me-1"></i> ข่าวสารประชาสัมพันธ์
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">เวลาทำการ</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <span class="text-white text-decoration-none small">
                                    <i class="bi bi-box-seam small text-muted me-1"></i> จุดสมาชิกสัมพันธ์ (สนญ.)
                                    <br>วันจันทร์-ศุกร์ 9.00-16.00
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr class="text-secondary">
                
                <div class="text-center text-muted small pb-2">
                    <p class="mb-1 text-white opacity-75">ลิขสิทธิ์โดยร้าน สหกรณ์มหาวิทยาลัยเชียงใหม่ จำกัด {{ new Date().getFullYear() }}</p>
                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">
                        &copy; {{ new Date().getFullYear() }} 
                        <a :href="route('admin.login')" class="text-decoration-none text-muted fw-bold hover-link">CMU X ACADEMY</a>. 
                        All Rights Reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* เอา CSS จาก app.blade.php มาใส่ที่นี่ */
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap');
    
    /* Navbar Styling */
    .navbar {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding-top: 10px;
        padding-bottom: 10px;
        position: relative;
        z-index: 1000;
        font-family: 'Prompt', sans-serif;
    }

    .logo-img {
        transition: all 0.3s ease;
        height: 50px; 
        width: auto;
    }

    .navbar-nav .nav-link {
        position: relative;
        color: #333;
        font-weight: 500;
        margin-left: 15px;
        margin-right: 15px;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link.active {
        color: #0d6efd !important;
        font-weight: 700;
    }

    .navbar-nav .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0px;
        width: 100%;
        height: 3px;
        background-color: #0d6efd;
        border-radius: 2px;
    }

    .navbar-nav .nav-link:not(.active):hover {
        color: #0d6efd;
    }

    /* Footer Hover */
    .hover-link {
        transition: all 0.3s ease;
        display: inline-block;
    }
    .hover-link:hover {
        color: #ffc107 !important;
        transform: translateX(5px);
        text-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
    }

    @media (min-width: 992px) {
        .navbar { height: 70px; }
        .logo-container { position: relative; }
        .logo-img {
            height: 100px; 
            position: absolute; 
            top: -45px; 
            left: 0;
            z-index: 1001; 
        }
        .logo-img:hover { transform: scale(1.05); }
        .navbar-collapse { margin-left: 120px; }
    }
</style>
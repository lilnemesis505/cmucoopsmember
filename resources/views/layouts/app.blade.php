<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMU X ACADEMY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- เรียกใช้ CSS จาก public/css/style.css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* CSS สำหรับ Navbar Active State */
        .nav-links li a {
            position: relative;
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        /* เมื่อเป็นสถานะ Active (หน้าปัจจุบัน) */
        .nav-links li a.active {
            color: #0d6efd !important; /* เปลี่ยนตัวหนังสือเป็นสีฟ้า */
            font-weight: 600;
        }

        /* สร้างเส้นขีดใต้ด้วย Pseudo-element */
        .nav-links li a.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px; /* ระยะห่างจากตัวหนังสือ */
            width: 100%;
            height: 3px; /* ความหนาของเส้น */
            background-color: #0d6efd; /* สีของเส้น (ฟ้า) */
            border-radius: 2px;
        }

        /* เพิ่มลูกเล่นตอนเอาเมาส์ชี้ (Hover) สำหรับอันที่ยังไม่ Active */
        .nav-links li a:not(.active):hover {
            color: #0d6efd;
        }

        /* --- Footer Styles --- */
        .hover-link {
            transition: all 0.3s ease;
            display: inline-block;
        }
        .hover-link:hover {
            color: #ffc107 !important; /* เปลี่ยนเป็นสีเหลืองทองตอนชี้ */
            transform: translateX(5px); /* ขยับไปทางขวานิดนึง */
            text-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }
        .border-bottom {
            border-bottom-width: 2px !important;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">CMU X ACADEMY</a>
        </div>
        <ul class="nav-links">
            {{-- ใช้ request()->routeIs('ชื่อ_route') เพื่อเช็คว่าอยู่หน้านั้นหรือไม่ --}}
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">หน้าหลัก</a>
            </li>
            <li>
                <a href="{{ route('member') }}" class="{{ request()->routeIs('member') ? 'active' : '' }}">สมาชิก</a>
            </li>
            <li>
                <a href="{{ route('board') }}" class="{{ request()->routeIs('board') ? 'active' : '' }}">ผู้ถือหุ้น</a>
            </li>
            <li>
                <a href="{{ route('check.member') }}" class="{{ request()->routeIs('check.member') ? 'active' : '' }}">ตรวจสอบสมาชิก</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        {{-- ส่วนเนื้อหาที่จะเปลี่ยนไปเรื่อยๆ --}}
        @yield('content')
    </div>

    <footer class="bg-dark text-white pt-5 pb-4 border-top mt-5">
    <div class="container-fluid">
        <div class="row">
            
            {{-- 1. ส่วนติดต่อสอบถาม --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3 fw-bold text-warning border-bottom border-warning d-inline-block pb-1">ติดต่อสอบถาม</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-3 text-success fs-5"></i>
                        <div>
                            <span class="d-block text-muted small" style="font-size: 0.8rem;">เบอร์โทรศัพท์</span>
                            <a href="tel:0999999999" class="text-white text-decoration-none hover-link">099-999-9999</a>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope-fill me-3 text-danger fs-5"></i>
                        <div>
                            <span class="d-block text-muted small" style="font-size: 0.8rem;">อีเมล</span>
                            <a href="mailto:cmucoop@gmail.com" class="text-white text-decoration-none hover-link">cmucoop@gmail.com</a>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-facebook me-3 text-primary fs-5"></i>
                        <div>
                            <span class="d-block text-muted small" style="font-size: 0.8rem;">Facebook</span>
                            <a href="https://www.facebook.com/share/1AD8Pi4Wf7/" target="_blank" class="text-white text-decoration-none hover-link">
                                CMUcoop X-cademy
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- 2. ลิงก์ที่เกี่ยวข้อง --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">ลิงก์ที่เกี่ยวข้อง</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="https://www.cmu-coops.com/" target="_blank" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-chevron-right small text-muted me-1"></i> ร้านสหกรณ์มหาวิทยาลัยเชียงใหม่
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://maps.app.goo.gl/QHP8sZCeuJ8hJ9f98" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-chevron-right small text-muted me-1"></i> ตำแหน่งร้านสหกรณ์มหาวิทยาลัยเชียงใหม่
                        </a>
                    </li>
                </ul>
            </div>

            {{-- 3. CMUCOOP'S --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">CMUCOOP'S</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-chevron-right small text-muted me-1"></i> เกี่ยวกับเรา
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://www.cmu-coops.com/coopnews.php" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-chevron-right small text-muted me-1"></i> ข่าวสารประชาสัมพันธ์
                        </a>
                    </li>
                </ul>
            </div>

            {{-- 4. หมวดหมู่สินค้า --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3 fw-bold border-bottom d-inline-block pb-1">หมวดหมู่สินค้า</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('admin.login') }}" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-box-seam small text-muted me-1"></i> สำหรับคนหล่อเท่านั้น
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none small hover-link">
                            <i class="bi bi-basket small text-muted me-1"></i> ขนมเบเกอรี่
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="text-secondary">
        
        <div class="text-center text-muted small">
            <p class="mb-0">
                © {{ date("Y") }} CMU X ACADEMY. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
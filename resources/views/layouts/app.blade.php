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
        /* --- Navbar Styling --- */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding-top: 10px;
            padding-bottom: 10px;
            position: relative;
            z-index: 1000;
        }

        /* --- Logo Styling (Responsive) --- */
        .logo-img {
            transition: all 0.3s ease;
            /* ค่าเริ่มต้นสำหรับมือถือ: ขนาดปกติ ไม่ลอย */
            height: 50px; 
            width: auto;
        }

        /* --- Menu Links Styling --- */
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

        /* เส้นขีดใต้ (เฉพาะตอน Active) */
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

        /* =========================================
           Desktop Only Styles (หน้าจอใหญ่กว่า 992px) 
           ========================================= */
        @media (min-width: 992px) {
            .navbar {
                height: 70px; /* ฟิกความสูงเฉพาะบน Desktop */
            }

            .logo-container {
                position: relative;
            }

            /* ทำให้โลโก้ใหญ่และลอยเฉพาะบนจอคอม */
            .logo-img {
                height: 100px; 
                position: absolute; 
                top: -45px; /* ดึงขึ้นไปข้างบน */
                left: 0;
                z-index: 1001; 
            }

            .logo-img:hover {
                transform: scale(1.05);
            }

            /* ดันเมนูไปทางขวาไม่ให้ทับโลโก้ */
            .navbar-collapse {
                margin-left: 120px; 
            }
        }

        /* --- Footer Styles --- */
        .hover-link {
            transition: all 0.3s ease;
            display: inline-block;
        }
        .hover-link:hover {
            color: #ffc107 !important;
            transform: translateX(5px);
            text-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }
        .border-bottom {
            border-bottom-width: 2px !important;
        }
    </style>
</head>
<body>

    {{-- ใช้โครงสร้าง Navbar ของ Bootstrap เพื่อรองรับ Mobile --}}
    <nav class="navbar navbar-expand-lg bg-white px-3 px-lg-4">
        <div class="container-fluid">
            
            {{-- ส่วนโลโก้ --}}
            <a class="navbar-brand logo-container" href="{{ route('home') }}">
                <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="CMU X-CADEMY" class="logo-img">
            </a>

            {{-- ปุ่ม Hamburger (จะโผล่มาเฉพาะตอนจอเล็ก) --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- รายการเมนู (จะถูกซ่อนในปุ่มตอนจอเล็ก) --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('member') ? 'active' : '' }}" href="{{ route('member') }}">สมาชิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('board') ? 'active' : '' }}" href="{{ route('board') }}">สิทธิพิเศษ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('check.member') ? 'active' : '' }}" href="{{ route('check.member') }}">ตรวจสอบสมาชิก</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top: 30px;">
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
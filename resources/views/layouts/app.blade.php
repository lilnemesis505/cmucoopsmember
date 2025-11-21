<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMU X ACADEMY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- เรียกใช้ CSS จาก public/css/style.css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">CMU X ACADEMY</a>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li><a href="{{ route('member') }}">สมาชิก</a></li>
            <li><a href="{{ route('board') }}">ผู้ถือหุ้น</a></li>
            <li><a href="#">อื่นๆ</a></li>
        </ul>
    </nav>

    <div class="container">
        {{-- ส่วนเนื้อหาที่จะเปลี่ยนไปเรื่อยๆ --}}
        @yield('content')
    </div>

    <footer class="bg-dark text-white pt-5 pb-4 border-top mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3 fw-bold">ติดต่อสอบถาม</h5>
                    <p class="mb-1 small">0-5321-7139</p>
                    <p class="mb-1 small">cmucoop@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3 fw-bold">ลิงก์ที่เกี่ยวข้อง</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">กระทรวงเกษตรและสหกรณ์</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">กรมตรวจบัญชีสหกรณ์</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3 fw-bold">CMUCOOP'S</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">เกี่ยวกับเรา</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">คณะกรรมการ</a></li>
                    </ul>
                </div>
                 <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3 fw-bold">หมวดหมู่สินค้า</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">เครื่องดื่ม</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none small">ขนมเบเกอรี่</a></li>
                    </ul>
                </div>
            </div>
            <hr class="text-muted">
            <div class="text-center text-muted small">
                <p class="mb-0">
                    &copy; {{ date("Y") }} CMU X ACADEMY. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
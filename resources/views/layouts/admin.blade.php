<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
        body { 
            font-family: 'Prompt', sans-serif;
            background-color: #f3f6f9;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* --- Sidebar --- */
        #sidebar-wrapper {
            min-width: 260px;
            max-width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #eef2f5;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        /* ส่วน Logo Admin */
        .sidebar-logo {
            height: 70px;  /* ความสูงกล่องเท่าเดิม (เท่า Navbar) */
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f0f0f0;
            background-color: #fff;
            overflow: hidden; /* ป้องกันรูปทะลุถ้าใหญ่เกิน */
        }

        .sidebar-logo img {
            /* ✅ แก้ตรงนี้: เพิ่มขนาดรูปให้ใหญ่ขึ้น (จาก 45px เป็น 60px) */
            height: 60px; 
            width: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-logo img:hover {
            transform: scale(1.05);
        }

        /* ส่วน Navbar บน */
        .top-navbar {
            height: 70px; /* ความสูงเท่ากับ Sidebar Logo */
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* -------------------------------- */

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -260px;
        }

        .list-group-item {
            border: none;
            padding: 15px 25px;
            font-size: 1rem;
            font-weight: 500;
            color: #3f5376;
            background-color: transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .list-group-item i {
            font-size: 1.2rem;
            color: #8fa0b8;
            min-width: 25px;
        }

        .list-group-item:hover {
            background-color: #f8faff;
            color: #0d47a1;
        }
        .list-group-item:hover i {
            color: #0d47a1;
        }

        .list-group-item.active {
            background-color: #eef4ff;
            color: #0d47a1;
            border-left: 4px solid #0d47a1;
            font-weight: 600;
        }
        .list-group-item.active i {
            color: #0d47a1;
        }

        #page-content-wrapper {
            width: 100%;
            flex: 1;
        }

        .btn-toggle {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #0d1e4c;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }
        
        .content-area {
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">

    {{-- Sidebar --}}
    <div id="sidebar-wrapper">
        
        {{-- แก้ไขส่วนแสดงโลโก้ --}}
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" target="_blank" title="ไปที่หน้าเว็บไซต์">
                <img src="https://ik.imagekit.io/cmucoopsmember/icon" alt="CMU X-CADEMY">
            </a>
        </div>

        <div class="list-group list-group-flush mt-2">
            
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> เมนูหลัก
            </a>

            {{-- จัดการ Banner --}}
            <a href="{{ route('admin.slides.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> จัดการแบนเนอร์
            </a>

            {{-- จัดการสิทธิพิเศษ --}}
            <a href="{{ route('admin.promotions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> จัดการสิทธิพิเศษ
            </a>

            {{-- จัดการเนื้อหาหน้าเว็บ --}}
            <a href="{{ route('admin.pages.edit', 'member') }}" class="list-group-item list-group-item-action {{ request()->is('admin/pages/member/edit') ? 'active' : '' }}">
                <i class="bi bi-list"></i> แก้ไขหน้า 1
            </a>

            <a href="{{ route('admin.pages.edit', 'board') }}" class="list-group-item list-group-item-action {{ request()->is('admin/pages/board/edit') ? 'active' : '' }}">
                <i class="bi bi-list"></i> แก้ไขหน้า 2
            </a>

            {{-- จัดการข่าวสาร --}}
            <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> ระบบข่าวสาร
            </a>

            {{-- จัดการสมาชิก --}}
            <a href="{{ route('admin.members.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> สมาชิก
            </a>
            
        </div>
        
        {{-- Logout --}}
        <div class="mt-auto p-3 border-top">
            <a href="{{ route('admin.logout') }}" class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right text-danger"></i> ออกจากระบบ
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div id="page-content-wrapper">

        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn-toggle me-3" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-bold text-primary d-none d-md-block">ระบบจัดการหลังบ้าน</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <small class="text-muted d-block" style="font-size: 0.75rem;">Login as</small>
                    <span class="fw-bold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </nav>

        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>

</body>
</html>
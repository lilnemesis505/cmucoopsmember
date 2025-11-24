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
            background-color: #f3f6f9; /* พื้นหลัง content สีเทาอ่อนๆ สบายตา */
            overflow-x: hidden; /* ป้องกัน scroll แนวนอนตอนซ่อนเมนู */
        }

        /* --- Wrapper Layout --- */
        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* --- Sidebar Design (ตามรูปตัวอย่าง) --- */
        #sidebar-wrapper {
            min-width: 260px;
            max-width: 260px;
            background-color: #ffffff; /* พื้นหลังขาว */
            border-right: 1px solid #eef2f5;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        /* กรณีซ่อน Sidebar */
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -260px;
        }

        /* --- Logo Area --- */
        .sidebar-heading {
            padding: 1.2rem 1.5rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: #0d1e4c; /* สีน้ำเงินเข้ม */
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        /* --- Menu Items --- */
        .list-group-item {
            border: none;
            padding: 15px 25px;
            font-size: 1rem;
            font-weight: 500;
            color: #3f5376; /* สีเทาอมน้ำเงิน */
            background-color: transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 15px; /* ระยะห่างไอคอนกับตัวหนังสือ */
        }

        .list-group-item i {
            font-size: 1.2rem;
            color: #8fa0b8; /* สีไอคอนจางๆ */
            min-width: 25px;
        }

        /* Hover & Active State */
        .list-group-item:hover {
            background-color: #f8faff;
            color: #0d47a1; /* สีน้ำเงินเข้มเมื่อชี้ */
        }
        .list-group-item:hover i {
            color: #0d47a1;
        }

        .list-group-item.active {
            background-color: #eef4ff; /* พื้นหลังสีฟ้าจางๆ */
            color: #0d47a1; /* ตัวหนังสือสีน้ำเงินเข้ม */
            border-left: 4px solid #0d47a1; /* แถบสีด้านซ้าย */
            font-weight: 600;
        }
        .list-group-item.active i {
            color: #0d47a1;
        }

        /* --- Main Content --- */
        #page-content-wrapper {
            width: 100%;
            flex: 1;
        }

        .top-navbar {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-toggle {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #0d1e4c;
            cursor: pointer;
        }
        
        .content-area {
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">

    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <i class="bi bi-building-fill text-primary"></i> CMU X-CADEMY
        </div>
        <div class="list-group list-group-flush mt-3">
            
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> เมนูหลัก
            </a>

            {{-- จัดการ Banner (สไลด์) --}}
            <a href="{{ route('admin.slides.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> จัดการแบนเนอร์
            </a>

            {{-- จัดการ Events --}}
            <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> ระบบข่าวสาร
            </a>

            {{-- จัดการสมาชิก --}}
            <a href="{{ route('admin.members.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> สมาชิก
            </a>
            
        </div>
        
        {{-- ปุ่ม Logout ด้านล่างสุด --}}
        <div class="mt-auto p-3 border-top">
            <a href="{{ route('admin.logout') }}" class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right text-danger"></i> ออกจากระบบ
            </a>
        </div>
    </div>
    <div id="page-content-wrapper">

        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                {{-- ปุ่มกดซ่อน Sidebar --}}
                <button class="btn-toggle me-3" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
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
            {{-- Flash Messages --}}
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

{{-- Script สำหรับปุ่ม Toggle --}}
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>

</body>
</html>
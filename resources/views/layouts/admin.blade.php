<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { display: flex; min-height: 100vh; flex-direction: column; }
        .wrapper { display: flex; width: 100%; flex: 1; }
        #sidebar { min-width: 250px; max-width: 250px; background: #212529; color: #fff; }
        #sidebar .nav-link { color: #adb5bd; }
        #sidebar .nav-link.active { color: #fff; background: #495057; }
        #content { width: 100%; padding: 25px; background: #f8f9fa; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
        <div class="ms-auto text-white">
            สวัสดี, {{ Auth::user()->name ?? 'Admin' }}
            <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm ms-2">Logout</a>
        </div>
    </div>
</nav>

<div class="wrapper">
    <nav id="sidebar" class="p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-fill me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" href="{{ route('admin.slides.index') }}">
                    <i class="bi bi-images me-2"></i> จัดการ Banner
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                    <i class="bi bi-newspaper me-2"></i> จัดการ Events
                </a>
            </li>
        </ul>
    </nav>

    <main id="content">
        {{-- แสดง Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Dashboard: <span class="text-primary">Overview</span></h2>

<div class="row g-4">
    {{-- 1. จัดการ Banner --}}
    <div class="col-md-3"> {{-- ปรับขนาดเป็น col-md-3 เพื่อให้เรียงสวยขึ้น --}}
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-images display-4 text-warning mb-3"></i>
                <h5>จัดการ Banner</h5>
                <p class="text-muted small">เปลี่ยนรูปสไลด์และแบนเนอร์</p>
                <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-warning btn-sm">จัดการ</a>
            </div>
        </div>
    </div>

    {{-- 2. จัดการ Events --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-newspaper display-4 text-success mb-3"></i>
                <h5>จัดการ Events</h5>
                <p class="text-muted small">แก้ไขข่าวสาร (ev1-ev6)</p>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-success btn-sm">จัดการ</a>
            </div>
        </div>
    </div>

    {{-- 3. จัดการสมาชิก (เพิ่มใหม่) --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 border-primary">
            <div class="card-body text-center">
                <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                <h5>จัดการสมาชิก</h5>
                <p class="text-muted small">Import Excel, เพิ่ม, ลบ, แก้ไข</p>
                <a href="{{ route('admin.members.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-file-earmark-spreadsheet"></i> จัดการ
                </a>
            </div>
        </div>
    </div>

    {{-- 4. หน้าบ้าน --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-house-door display-4 text-secondary mb-3"></i>
                <h5>หน้าบ้าน</h5>
                <p class="text-muted small">ดูหน้าเว็บจริง</p>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm">เปิดดู</a>
            </div>
        </div>
    </div>
</div>

@endsection
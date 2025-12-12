@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Dashboard: <span class="text-primary">ภาพรวมระบบ</span></h2>

<div class="row g-4">
    {{-- 1. จัดการ Banner --}}
    <div class="col-md-3"> 
        <div class="card shadow-sm h-100 hover-card">
            <div class="card-body text-center">
                <i class="bi bi-images display-4 text-warning mb-3"></i>
                <h5>จัดการ Banner</h5>
                <p class="text-muted small">รูปสไลด์หน้าแรก</p>
                <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-warning btn-sm w-100">จัดการ</a>
            </div>
        </div>
    </div>

    {{-- 2. จัดการสิทธิพิเศษ --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 hover-card">
            <div class="card-body text-center">
                <i class="bi bi-gift-fill display-4 text-danger mb-3"></i>
                <h5>สิทธิพิเศษ</h5>
                <p class="text-muted small">โปรโมชั่น/สิทธิประโยชน์</p>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-danger btn-sm w-100">จัดการ</a>
            </div>
        </div>
    </div>

    {{-- 3. [ใหม่] จัดการผู้ร่วมรายการ (Board) --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 hover-card border-success">
            <div class="card-body text-center">
                <i class="bi bi-layers-fill display-4 text-success mb-3"></i>
                <h5 class="fw-bold text-success">หน้าผู้ร่วม</h5>
                <p class="text-muted small">เพิ่ม/ลบ หัวข้อสิทธิประโยชน์</p>
                <a href="{{ route('admin.board.index') }}" class="btn btn-success btn-sm w-100">จัดการข้อมูล</a>
            </div>
        </div>
    </div>

    {{-- 4. จัดการ Events --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 hover-card">
            <div class="card-body text-center">
                <i class="bi bi-calendar-event display-4 text-primary mb-3"></i>
                <h5>ข่าวสารกิจกรรม</h5>
                <p class="text-muted small">กิจกรรม (Events)</p>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary btn-sm w-100">จัดการ</a>
            </div>
        </div>
    </div>

    {{-- 5. จัดการสมาชิก --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 hover-card border-primary">
            <div class="card-body text-center">
                <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                <h5>ฐานข้อมูลสมาชิก</h5>
                <p class="text-muted small">ค้นหา, Import Excel</p>
                <a href="{{ route('admin.members.index') }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search"></i> ตรวจสอบ
                </a>
            </div>
        </div>
    </div>

    {{-- 6. หน้าบ้าน --}}
    <div class="col-md-3">
        <div class="card shadow-sm h-100 hover-card bg-light">
            <div class="card-body text-center">
                <i class="bi bi-house-door display-4 text-secondary mb-3"></i>
                <h5>หน้าเว็บไซต์</h5>
                <p class="text-muted small">เปิดดูหน้าบ้านจริง</p>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">Go to Website</a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>

@endsection
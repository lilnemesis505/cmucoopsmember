@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Dashboard: <span class="text-primary">Traffic Overview</span></h2>


<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-images display-4 text-warning mb-3"></i>
                <h5>จัดการ Banner</h5>
                <p class="text-muted small">เปลี่ยนรูปสไลด์และแบนเนอร์ข้าง</p>
                <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-warning btn-sm">ไปจัดการ</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-newspaper display-4 text-success mb-3"></i>
                <h5>จัดการ Events</h5>
                <p class="text-muted small">แก้ไขข่าวสารและอัลบั้มรูปภาพ (ev1-ev6)</p>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-success btn-sm">ไปจัดการ</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
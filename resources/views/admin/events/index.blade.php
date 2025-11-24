@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0">จัดการข่าวสารและกิจกรรม (Events)</h1>
        <p class="text-muted mb-0">กรุณาเลือก Event ที่ต้องการแก้ไขอัลบั้มรูปภาพ</p>
    </div>
    
    {{-- ปุ่ม Sync ข้อมูล --}}
    <a href="{{ route('admin.events.sync') }}" class="btn btn-warning shadow-sm" onclick="return confirm('ระบบจะดึงข้อมูลรูปภาพทั้งหมดจาก ImageKit ลงมาในฐานข้อมูล\nยืนยันการทำงานหรือไม่?');">
        <i class="bi bi-cloud-download-fill me-2"></i> Sync รูปจาก Cloud
    </a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    {{-- วนลูปสร้างการ์ด ev1 ถึง ev6 --}}
    @foreach (['ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'] as $index => $key)
    <div class="col">
        <div class="card h-100 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <i class="bi bi-calendar-event-fill display-4 text-primary mb-3"></i>
                
                <h5 class="card-title fw-bold">Event {{ $index + 1 }} ({{ $key }})</h5>
                <p class="card-text text-muted small">จัดการหัวข้อ รายละเอียด และอัลบั้มรูปภาพสำหรับหน้า {{ $key }}</p>
                
                {{-- ลิงก์ไปยังหน้าแก้ไข (admin.events.edit) พร้อมส่ง key ไปด้วย --}}
                <a href="{{ route('admin.events.edit', $key) }}" class="btn btn-primary mt-2">
                    <i class="bi bi-pencil-square me-1"></i> ไปที่หน้าจัดการ
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); border-color: #0d6efd; }
</style>

@endsection
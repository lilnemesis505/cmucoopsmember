@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0 fw-bold"><i class="bi bi-calendar-week"></i> จัดการข่าวสารและกิจกรรม</h2>
        <p class="text-muted small mb-0">รายการกิจกรรมทั้งหมดในระบบ (เรียงตามลำดับ)</p>
    </div>
    
    <div>
        {{-- ปุ่มเพิ่มกิจกรรม (ปรับให้ชัดเจนขึ้น) --}}
        <form action="{{ route('admin.events.create') }}" method="POST" class="d-inline me-2">
            @csrf
            <button type="submit" class="btn btn-success shadow-sm btn-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> เพิ่มกิจกรรมใหม่
            </button>
        </form>

        {{-- ปุ่ม Sync --}}
        <a href="{{ route('admin.events.sync') }}" class="btn btn-outline-warning btn-sm shadow-sm" onclick="return confirm('ยืนยันการ Sync รูปจาก Cloud?');">
            <i class="bi bi-cloud-download-fill"></i> Sync รูป
        </a>
    </div>
</div>

@php
    $events = \App\Models\Event::all(); 
    $events = $events->sortBy(function($event) {
        return (int) str_replace('ev', '', $event->key);
    });
@endphp

{{-- ปรับ Grid: row-cols-lg-4 (แถวละ 4 กล่อง), row-cols-md-3 (แถวละ 3 กล่อง) --}}
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
    @forelse ($events as $event)
        @php
            $coverImage = $event->images->first(); 
        @endphp

    <div class="col">
        <div class="card h-100 shadow-sm border-0 hover-card">
            
            {{-- ส่วนรูปภาพ (ลดขนาดความสูงลงเหลือ 120px) --}}
            <div class="position-relative bg-light" style="height: 120px; overflow: hidden;">
                @if($coverImage)
                    <img src="{{ $coverImage->image_url }}?tr=w-300,h-200,c-auto" 
                         class="w-100 h-100" 
                         style="object-fit: cover;" 
                         alt="{{ $event->title }}">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-secondary opacity-25">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                    </div>
                @endif
                
                {{-- Badge Key มุมขวาบน --}}
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-dark bg-opacity-75 rounded-pill small">{{ $event->key }}</span>
                </div>
            </div>

            <div class="card-body p-3"> {{-- ลด Padding --}}
                {{-- ชื่อกิจกรรม (ตัดคำถ้าชาวเกิน) --}}
                <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $event->title }}">
                    {{ $event->title ?? 'ไม่มีชื่อกิจกรรม' }}
                </h6>
                
                {{-- วันที่ --}}
                <p class="text-primary small mb-2" style="font-size: 0.75rem;">
                    <i class="bi bi-calendar3"></i> 
                    {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') : '-' }}
                </p>

                {{-- รายละเอียด (ตัดคำ 2 บรรทัด) --}}
                <p class="card-text text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.6em; line-height: 1.3;">
                    {{ $event->description ?? '-' }}
                </p>
                
                <a href="{{ route('admin.events.edit', $event->key) }}" class="btn btn-outline-primary btn-sm w-100 mt-2 stretched-link">
                    <i class="bi bi-gear-fill me-1"></i> จัดการ
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-light text-center py-5 border dashed-border">
            <i class="bi bi-inbox display-4 text-muted mb-3"></i>
            <h5 class="text-muted">ยังไม่มีกิจกรรม</h5>
            <p class="small text-muted">กดปุ่ม "เพิ่มกิจกรรมใหม่" ด้านบนเพื่อเริ่มต้น</p>
        </div>
    </div>
    @endforelse
</div>

<style>
    .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
    }
    .dashed-border {
        border: 2px dashed #dee2e6;
    }
</style>

@endsection
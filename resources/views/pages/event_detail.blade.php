@extends('layouts.app')

@section('content')
<div class="container my-5">
    
    {{-- ส่วนหัวข้อและรายละเอียด --}}
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            
            {{-- ลิงก์ย้อนกลับ --}}
            <a href="{{ route('home') }}" class="text-decoration-none text-muted mb-2 d-block">
                &laquo; กลับไปหน้าข่าวสาร
            </a>
            
            {{-- หัวข้อ (Title) --}}
            <h1 class="fw-bold">{{ $event->title }}</h1>
            
            {{-- รายละเอียด (Description) --}}
            {{-- ใช้ {!! !!} และ nl2br(e(...)) เพื่อให้เว้นบรรทัดได้เหมือน PHP เดิม --}}
            <p class="lead text-muted mt-3">
                {!! nl2br(e($event->description)) !!}
            </p>
            <hr>
        </div>
    </div>

    {{-- ส่วนอัลบั้มรูปภาพ --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h3 class="mb-3">อัลบั้มรูปภาพ ({{ $event->images->count() }} รูป)</h3>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                
                {{-- กรณีไม่มีรูป --}}
                @if ($event->images->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-secondary text-center">
                            ยังไม่มีรูปภาพในอัลบั้มนี้
                        </div>
                    </div>
                @else
                    {{-- วนลูปรูปภาพ (เหมือน foreach ใน PHP เดิม) --}}
                    @foreach ($event->images as $image)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            {{-- รูปภาพ --}}
                            <img src="{{ $image->image_url }}?tr=w-600,h-400,c-auto" 
                                 class="card-img-top" 
                                 alt="Event Photo"
                                 style="object-fit: cover; height: 250px;"> {{-- จัดระเบียบความสูงให้เท่ากัน --}}
                        </div>
                    </div>
                    @endforeach
                @endif
                
            </div>
            
        </div>
    </div>
    
</div>
@endsection
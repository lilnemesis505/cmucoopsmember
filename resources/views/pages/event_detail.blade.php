@extends('layouts.app')

@section('content')
<div class="container my-5">
    
    {{-- ส่วนหัวข้อและรายละเอียด --}}
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted mb-2 d-block">
                &laquo; กลับไปหน้าข่าวสาร
            </a>
            <h1 class="fw-bold">{{ $event->title }}</h1>
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
                @if ($event->images->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-secondary text-center">
                            ยังไม่มีรูปภาพในอัลบั้มนี้
                        </div>
                    </div>
                @else
                    @foreach ($event->images as $image)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            {{-- 
                                รูปภาพ Thumbnail 
                                - เมื่อคลิกจะเรียกฟังก์ชัน showImagePopup()
                                - ส่ง URL รูปเต็ม (ไม่มี ?tr=...) เข้าไปในฟังก์ชัน
                            --}}
                            <img src="{{ $image->image_url }}?tr=w-600,h-400,c-auto" 
                                 class="card-img-top" 
                                 alt="Event Photo"
                                 onclick="showImagePopup('{{ $image->image_url }}')"
                                 style="object-fit: cover; height: 250px; cursor: zoom-in;">
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL POPUP สำหรับแสดงรูปใหญ่ --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> {{-- modal-lg เพื่อให้รูปใหญ่ชัดเจน --}}
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                
                {{-- ปุ่มปิดมุมขวาบน --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" aria-label="Close" 
                        style="z-index: 10; background-color: rgba(0,0,0,0.5); padding: 10px; border-radius: 50%;">
                </button>

                {{-- พื้นที่แสดงรูปใหญ่ --}}
                <img id="popupImage" src="" class="img-fluid rounded shadow" style="max-height: 90vh;">
            </div>
        </div>
    </div>
</div>

{{-- JavaScript สำหรับจัดการ Popup --}}
<script>
    function showImagePopup(fullImageUrl) {
        // 1. เอารูปที่ส่งมาใส่ใน tag img ของ Modal
        document.getElementById('popupImage').src = fullImageUrl;
        
        // 2. เรียก Bootstrap Modal ให้แสดงขึ้นมา
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }
</script>

@endsection
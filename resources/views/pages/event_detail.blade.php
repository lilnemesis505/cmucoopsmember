@extends('layouts.app')

@section('content')
<div class="container my-5">
    
    {{-- ส่วนหัวข้อและรายละเอียด --}}
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted mb-2 d-block">
                &laquo; กลับไปหน้าข่าวสาร
            </a>
            
            <h1 class="fw-bold mb-2">{{ $event->title }}</h1>
            
            {{-- [ส่วนที่เพิ่มใหม่] แสดงวันที่จัดกิจกรรม (ถ้ามี) --}}
            @if($event->event_date)
                <p class="text-primary mb-3">
                    <i class="bi bi-calendar-event-fill me-2"></i> 
                    วันที่จัดกิจกรรม: {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                </p>
            @endif

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
                                - ใช้ onclick เรียกฟังก์ชัน JS ด้านล่าง 
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
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

{{-- Script สั่งเปิด Popup --}}
<script>
    function showImagePopup(fullImageUrl) {
        // เอารูปที่ส่งมาใส่ใน tag img ของ Modal
        document.getElementById('popupImage').src = fullImageUrl;
        
        // เรียก Bootstrap Modal ให้แสดงขึ้นมา
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }
</script>

@endsection
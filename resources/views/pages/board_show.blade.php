@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- ปุ่มย้อนกลับ --}}
            <a href="{{ route('board') }}" class="btn btn-light text-muted mb-4 rounded-pill shadow-sm">
                <i class="bi bi-arrow-left"></i> กลับหน้ารวม
            </a>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- หัวข้อหลัก --}}
                    <h1 class="mb-2 text-center text-success fw-bold">{{ $post->title }}</h1>

                    {{-- หัวข้อรอง --}}
                    @if($post->subtitle)
                        <h4 class="text-muted text-center mb-4">{{ $post->subtitle }}</h4>
                    @endif
                    
                    <hr class="my-4">

                    {{-- เนื้อหา --}}
                    <div class="content-body" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! $post->content !!}
                    </div>

                    {{-- รูปภาพท้ายเว็บ (Gallery) --}}
                    @if(!empty($post->images))
                    <div class="row g-4 mt-4">
                        @foreach($post->images as $img)
                        <div class="col-md-6">
                            {{-- [แก้ไข] เพิ่ม onclick และ style cursor --}}
                            <div class="overflow-hidden rounded shadow-sm position-relative group-hover-zoom">
                                <img src="{{ $img }}" 
                                     class="img-fluid w-100" 
                                     style="cursor: zoom-in; transition: transform 0.3s ease;"
                                     onclick="showImagePopup('{{ $img }}')">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- [เพิ่มใหม่] Modal สำหรับแสดงรูปขยายใหญ่ --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                {{-- ปุ่มปิด --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle" 
                        data-bs-dismiss="modal" aria-label="Close" style="z-index: 1050;"></button>
                
                {{-- รูปที่จะแสดง --}}
                <img id="popupImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 90vh;">
            </div>
        </div>
    </div>
</div>

{{-- [เพิ่มใหม่] Script สั่งงาน --}}
<script>
    function showImagePopup(src) {
        // 1. ดึง Element รูปใน Modal
        var popupImg = document.getElementById('popupImage');
        
        // 2. ถ้าใช้ ImageKit หรือมีการย่อรูปใน URL ให้ลบ Parameter ออกเพื่อให้ได้รูปชัดสุด
        // (เช่น ลบ ?tr=w-400 ออก)
        var fullSizeSrc = src.split('?')[0]; 
        
        // 3. ตั้งค่า src ใหม่
        popupImg.src = fullSizeSrc;

        // 4. เปิด Modal
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }
</script>

<style>
    /* เอฟเฟกต์ตอนเอาเมาส์ชี้รูป */
    .group-hover-zoom:hover img {
        transform: scale(1.03);
    }
</style>

@endsection
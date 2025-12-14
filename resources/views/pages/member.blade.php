@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    <h1 class="mb-2 text-center text-primary fw-bold">{{ $page->title }}</h1>
                    @if($page->subtitle)
                        <h4 class="text-muted text-center mb-4">{{ $page->subtitle }}</h4>
                    @endif
                    
                    <hr class="my-4">

                    <div class="content-body" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! $page->content !!}
                    </div>

                    @if(!empty($page->images))
                    <div class="row g-4 mt-4">
                        @foreach($page->images as $img)
                        <div class="col-md-6">
                            {{-- [แก้ไขจุดที่ 1] เพิ่ม onclick และ style cursor --}}
                            <img src="{{ $img }}" 
                                 class="img-fluid rounded shadow-sm w-100 hover-zoom"
                                 style="cursor: zoom-in;"
                                 onclick="showImagePopup('{{ $img }}')">
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- [แก้ไขจุดที่ 2] เพิ่ม Modal สำหรับแสดงรูปขยายใหญ่ --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                {{-- ปุ่มปิด --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle" 
                        data-bs-dismiss="modal" aria-label="Close" style="z-index: 1050;"></button>
                
                {{-- รูปที่จะแสดง --}}
                <img id="popupImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 90vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

{{-- [แก้ไขจุดที่ 3] เพิ่ม Script สั่งงาน Popup --}}
<script>
    function showImagePopup(src) {
        // 1. ดึง Element รูปใน Modal
        var popupImg = document.getElementById('popupImage');
        
        // 2. ลบ Parameter ย่อรูป (ถ้ามี) ออกเพื่อให้ได้รูปขนาดเต็ม
        // เช่น ถ้า url คือ image.jpg?tr=w-400 จะเหลือแค่ image.jpg
        var fullSizeSrc = src.split('?')[0]; 
        
        // 3. ตั้งค่า src ใหม่ให้กับรูปใน Modal
        popupImg.src = fullSizeSrc;

        // 4. สั่งเปิด Modal
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }
</script>

@endsection
@extends('layouts.app')

@section('content')

{{-- เรียกใช้ Google Fonts --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap');

    body { font-family: 'Prompt', sans-serif; }

    .section-title {
        position: relative; display: inline-block; font-weight: 700; color: #2c3e50; margin-bottom: 1.5rem;
    }
    .section-title::after {
        content: ''; position: absolute; width: 50%; height: 4px;
        background: linear-gradient(to right, #0d6efd, #0dcaf0);
        bottom: -8px; left: 0; border-radius: 2px;
    }

    .hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }

    .btn-custom { border-radius: 50px; padding: 8px 25px; font-weight: 500; transition: all 0.3s; }
    .btn-custom:hover { transform: scale(1.05); }
    
    /* Cursor เป็นรูปแว่นขยาย */
    .zoom-cursor { cursor: zoom-in; }
</style>

{{-- ส่วน Banner สไลด์ --}}
<section class="banner-section mt-4">
    <div class="row g-3">
        
        {{-- 1. Main Banner (สไลด์หลัก) --}}
        <div class="col-lg-8">
            <div class="main-banner shadow-sm rounded-3 overflow-hidden">
                <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        @forelse ($slides as $index => $slide)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                {{-- เพิ่ม onclick และ class zoom-cursor --}}
                                <img src="{{ $slide->image_url }}?tr=w-800,h-400,c-maintain_ratio" 
                                     class="d-block w-100 zoom-cursor" 
                                     alt="Slide {{ $index + 1 }}"
                                     style="height: 400px; object-fit: cover;"
                                     onclick="showImagePopup('{{ $slide->image_url }}')"> 
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/800x400.png?text=No+slides+found" 
                                     class="d-block w-100" style="height: 400px; object-fit: cover;">
                            </div>
                        @endforelse
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- 2. Side Banners (แบนเนอร์ข้าง) --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3 h-100">
                <img src="{{ $banner1 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded-3 w-100 shadow-sm hover-card zoom-cursor" 
                     alt="Side Banner 1"
                     style="height: 190px; object-fit: cover;"
                     onclick="showImagePopup('{{ $banner1 }}')"> 

                <img src="{{ $banner2 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded-3 w-100 shadow-sm hover-card zoom-cursor" 
                     alt="Side Banner 2"
                     style="height: 190px; object-fit: cover;"
                     onclick="showImagePopup('{{ $banner2 }}')">
            </div>
        </div>
        
    </div>
</section>

<div class="my-5"></div>

{{-- 3. ส่วนสิทธิพิเศษ --}}
<section class="promotion-section">
    @foreach($promotions as $index => $promo)
        @php
            $link = '#'; 
            if ($index == 0) $link = route('member');
            elseif ($index == 1) $link = route('board');
        @endphp

    <div class="card mb-5 border-0 shadow-sm overflow-hidden hover-card">
        <div class="row g-0 align-items-center">
            <div class="col-md-5">
                <div class="p-2">
                    {{-- เพิ่ม onclick ให้รูป Promotion ด้วยเผื่ออยากดูรูปใหญ่ --}}
                    <img src="{{ $promo->image_url }}?tr=w-600,h-400" 
                         class="img-fluid rounded-3 w-100 zoom-cursor" 
                         alt="{{ $promo->main_title }}"
                         style="height: 280px; object-fit: cover;"
                         onclick="showImagePopup('{{ $promo->image_url }}')">
                </div>
            </div>
            <div class="col-md-7">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="card-title fw-bold text-primary mb-3" style="border-left: 5px solid #0d6efd; padding-left: 15px;">
                        {{ $promo->main_title }}
                    </h2>
                    <p class="card-text text-secondary fs-5" style="line-height: 1.8; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $promo->subtitle }}
                    </p>
                    <a href="{{ $link }}" class="btn btn-primary btn-custom mt-3 shadow-sm">
                        ดูรายละเอียดเพิ่มเติม <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</section>

<hr class="my-5 opacity-25">

{{-- ส่วนข่าวสาร (Events) --}}
<section class="news-section mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h2 class="section-title h1 m-0">ข่าวสารและกิจกรรม</h2>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($events as $event)
            @php
                $coverUrl = $event->coverImage->image_url ?? 'https://via.placeholder.com/400x225.png?text=Event+Cover';
            @endphp
            <div class="col">
                <div class="card h-100 shadow-sm hover-card rounded-4 overflow-hidden bg-white">
                    <div class="position-relative">
                        <img src="{{ $coverUrl }}?tr=w-400,h-250,c-auto" 
                             class="card-img-top" width="100%" height="225" 
                             alt="{{ $event->title }}" style="object-fit: cover;">
                        
                        @if(isset($event->created_at))
                        <div class="position-absolute bottom-0 start-0 bg-white px-3 py-1 m-2 rounded-pill shadow-sm small fw-bold text-primary">
                            <i class="bi bi-calendar3"></i> {{ $event->created_at->format('d M Y') }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-dark mb-3" style="line-height: 1.5;">
                            {{ Str::limit($event->title ?? 'Event ' . $event->key, 50) }}
                        </h5>
                        <p class="card-text text-muted mb-4 flex-grow-1" style="font-size: 0.95rem;">
                            {{ Str::limit($event->description, 90) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('event.show', $event->key) }}" class="text-decoration-none fw-bold text-primary">
                                อ่านต่อ <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- MODAL POPUP (Lightbox) --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"> {{-- ใช้ modal-xl เพื่อให้กว้างเต็มตา --}}
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                {{-- ปุ่มปิด --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" aria-label="Close" 
                        style="z-index: 10; background-color: rgba(0,0,0,0.5); padding: 10px; border-radius: 50%;">
                </button>
                {{-- รูปภาพใหญ่ --}}
                <img id="popupImage" src="" class="img-fluid rounded shadow" style="max-height: 90vh; width: auto;">
            </div>
        </div>
    </div>
</div>

{{-- Script จัดการ Popup และความคมชัด --}}
<script>
    function showImagePopup(fullImageUrl) {
        // 1. ลบ Parameter ย่อรูปเดิมออก (เช่น ?tr=w-400...)
        var baseUrl = fullImageUrl.split('?')[0]; 
        
        // 2. เติม Parameter ใหม่เพื่อบังคับขนาด FHD (Width: 1920px)
        // ImageKit จะทำการ Resize ให้ชัดเป๊ะที่ 1920px
        var fhdUrl = baseUrl + "?tr=w-1920";

        // 3. ใส่ URL ลงใน Modal
        document.getElementById('popupImage').src = fhdUrl;
        
        // 4. เปิด Modal
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }
</script>

@endsection
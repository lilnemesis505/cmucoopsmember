@extends('layouts.app')

@section('content')

{{-- เรียกใช้ Google Fonts (Prompt) เพื่อความสวยงาม --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap');

    body {
        font-family: 'Prompt', sans-serif;
    }

    /* ตกแต่งหัวข้อ Section */
    .section-title {
        position: relative;
        display: inline-block;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
    }
    .section-title::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 4px;
        background: linear-gradient(to right, #0d6efd, #0dcaf0); /* เส้นไล่สีฟ้า */
        bottom: -8px;
        left: 0;
        border-radius: 2px;
    }

    /* เอฟเฟกต์การ์ดข่าวสารตอนเอาเมาส์ชี้ */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .hover-card:hover {
        transform: translateY(-5px); /* ลอยขึ้น */
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    /* ปรับแต่งปุ่ม */
    .btn-custom {
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-custom:hover {
        transform: scale(1.05);
    }
</style>

{{-- ส่วน Banner สไลด์ --}}
<section class="banner-section mt-4">
    <div class="row g-3"> {{-- g-3 เพื่อลดช่องว่างระหว่างคอลัมน์เล็กน้อย --}}
        
        {{-- 1. Main Banner --}}
        <div class="col-lg-8">
            <div class="main-banner shadow-sm rounded-3 overflow-hidden">
                <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        @forelse ($slides as $index => $slide)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ $slide->image_url }}?tr=w-800,h-400,c-maintain_ratio" 
                                     class="d-block w-100" 
                                     alt="Slide {{ $index + 1 }}"
                                     style="height: 400px; object-fit: cover;"> 
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

        {{-- 2. Side Banners --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3 h-100">
                <img src="{{ $banner1 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded-3 w-100 shadow-sm hover-card" 
                     alt="Side Banner 1"
                     style="height: 190px; object-fit: cover; cursor: pointer;">

                <img src="{{ $banner2 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded-3 w-100 shadow-sm hover-card" 
                     alt="Side Banner 2"
                     style="height: 190px; object-fit: cover; cursor: pointer;">
            </div>
        </div>
        
    </div>
</section>

<div class="my-5"></div> {{-- เว้นระยะ --}}

{{-- 3. ส่วนสมาชิกและผู้ถือหุ้น (Promotions) --}}
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
                    <img src="{{ $promo->image_url }}?tr=w-600,h-400" 
                         class="img-fluid rounded-3 w-100" 
                         alt="{{ $promo->main_title }}"
                         style="height: 280px; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-7">
                <div class="card-body p-4 p-lg-5">
                    {{-- หัวข้อแบบมีขีดสีด้านหน้า --}}
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
        <a href="#" class="text-decoration-none text-muted small hover-link">ดูทั้งหมด <i class="bi bi-chevron-right"></i></a>
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
                        
                        {{-- วันที่ (ถ้ามี field วันที่) --}}
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

@endsection
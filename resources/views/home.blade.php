@extends('layouts.app')

@section('content')

{{-- ส่วนสมาชิกและผู้ถือหุ้น (Static Content) --}}
<section class="banner-section mt-3">
    <div class="row"> {{-- เพิ่ม row เพื่อจัด layout ให้สวยงาม --}}
        
        {{-- 1. Main Banner (สไลด์หลัก) --}}
        <div class="col-lg-8 mb-3">
            <div class="main-banner">
                <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner rounded overflow-hidden"> {{-- เพิ่ม rounded --}}
                        @forelse ($slides as $index => $slide)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                {{-- Lock ความสูงไว้ที่ 400px --}}
                                <img src="{{ $slide->image_url }}?tr=w-800,h-400,c-maintain_ratio" 
                                     class="d-block w-100" 
                                     alt="Slide {{ $index + 1 }}"
                                     style="height: 400px; object-fit: cover;"> 
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/800x400.png?text=No+slides+found" 
                                     class="d-block w-100" 
                                     alt="Default Banner"
                                     style="height: 400px; object-fit: cover;">
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

        {{-- 2. Side Banners (แบนเนอร์ข้างๆ) --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3"> {{-- ใช้ Flex จัดเรียงแนวตั้ง --}}
                {{-- Lock ความสูงไว้ที่ 190px (2 รูป รวมช่องว่างจะได้ใกล้เคียง 400px) --}}
                <img src="{{ $banner1 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded w-100" 
                     alt="Side Banner 1"
                     style="height: 190px; object-fit: cover;">

                <img src="{{ $banner2 }}?tr=w-400,h-200,c-maintain_ratio" 
                     class="img-fluid rounded w-100" 
                     alt="Side Banner 2"
                     style="height: 190px; object-fit: cover;">
            </div>
        </div>
        
    </div>
</section>

<hr class="my-5">

{{-- 3. ส่วนสมาชิกและผู้ถือหุ้น (Promotions) --}}
@foreach($promotions as $index => $promo)
    @php
        // กำหนดลิงก์ตามลำดับของข้อมูล (อันบน=0, อันล่าง=1)
        $link = '#'; 
        if ($index == 0) {
            $link = route('member'); // อันบน ไปหน้าสมาชิก
        } elseif ($index == 1) {
            $link = route('board');  // อันล่าง ไปหน้าผู้ถือหุ้น
        }
    @endphp

<div class="row mb-5 align-items-center bg-white p-4 rounded shadow-sm" style="min-height: 300px;">
    <div class="col-md-5">
        <img src="{{ $promo->image_url }}?tr=w-600,h-400" 
             class="img-fluid rounded w-100" 
             alt="{{ $promo->main_title }}"
             style="height: 250px; object-fit: cover;">
    </div>
    <div class="col-md-7">
        <h3 class="fw-bold mt-3 mt-md-0">{{ $promo->main_title }}</h3>
        
        <p class="text-muted" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
            {{ $promo->subtitle }}
        </p>
        
        {{-- ใช้ตัวแปร $link ที่เรากำหนดข้างบน --}}
        <a href="{{ $link }}" class="btn btn-primary mt-2">
            ดูรายละเอียดเพิ่มเติม
        </a>
    </div>
</div>
@endforeach

<hr class="my-5">

{{-- ส่วนข่าวสาร (Events) --}}
<section class="news-section mb-5">
    <h2>ข่าวสารและกิจกรรม X-CADEMY</h2>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach ($events as $event)
            @php
                $coverUrl = $event->coverImage->image_url ?? 'https://via.placeholder.com/400x225.png?text=Event+Cover';
            @endphp
            <div class="col">
                <div class="card shadow-sm h-100">
                    <img src="{{ $coverUrl }}?tr=w-400,h-225,c-auto" 
                         class="bd-placeholder-img card-img-top" width="100%" height="225" 
                         alt="{{ $event->title }}">
                    
                    <div class="card-body">
                        <p class="card-text fw-bold">{{ $event->title ?? 'Event ' . $event->key }}</p>
                        <p class="card-text small text-muted">{{ Str::limit($event->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="btn-group">
                                {{-- ลิงก์ไปหน้ารายละเอียด (ต้องสร้าง Route เพิ่ม) --}}
                                <a href="{{ route('event.show', $event->key) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
@extends('layouts.app')

@section('content')

{{-- ส่วน Banner --}}
<section class="banner-section mt-3">
    <div class="main-banner">
        <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @forelse ($slides as $index => $slide)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ $slide->image_url }}?tr=w-800,h-400,c-auto" class="d-block w-100" alt="Slide {{ $index + 1 }}">
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/800x400.png?text=No+slides+found" class="d-block w-100" alt="Default Banner">
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

    <div class="side-banners">
        <img src="{{ $banner1 }}?tr=w-400,h-200,c-auto" alt="Side Banner 1">
        <img src="{{ $banner2 }}?tr=w-400,h-200,c-auto" alt="Side Banner 2">
    </div>
</section>

<hr class="my-5">

{{-- ส่วนสมาชิกและผู้ถือหุ้น (Static Content) --}}
<section class="members-section my-4">
    <div class="row align-items-center">
        <div class="col-md-5">
            <img src="https://ik.imagekit.io/cmuxacademy/member?updatedAt=1762759404324&tr=w-400,h-200,c-auto" class="img-fluid rounded shadow-sm" alt="สมาชิก">
        </div>
        <div class="col-md-7">
            <h4>สิทธิประโยชน์สำหรับสมาชิก</h4>
            <p>รายละเอียดเกี่ยวกับสิทธิประโยชน์ต่างๆ...</p>
            <a href="{{ route('member') }}" class="btn btn-primary btn-sm">ดูรายละเอียดเพิ่มเติม</a>
        </div>
    </div>
</section>

<hr class="my-4">

<section class="members-section my-4">
    <div class="row align-items-center">
        <div class="col-md-5">
            <img src="https://ik.imagekit.io/cmuxacademy/board?updatedAt=1762759204491&tr=w-400,h-200,c-auto" class="img-fluid rounded shadow-sm" alt="ผู้ถือหุ้น">
        </div>
        <div class="col-md-7">
            <h4>สิทธิประโยชน์สำหรับผู้ถือหุ้นสหกรณ์</h4>
            <p>เมื่อผู้สมัครสมาชิก จ่ายเงิน 100 บาท...</p>
            <a href="{{ route('board') }}" class="btn btn-primary btn-sm">ดูรายละเอียดเพิ่มเติม</a>
        </div>
    </div>
</section>

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
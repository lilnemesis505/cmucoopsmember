@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- หัวข้อหลัก --}}
            <h1 class="mb-4 text-center text-primary fw-bold">
                {{ $page->title ?? 'สิทธิประโยชน์สำหรับสมาชิก' }}
            </h1>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- หัวข้อรอง --}}
                    <h3 class="card-title text-dark fw-bold mb-3 border-start border-5 border-primary ps-3">
                        {{ $page->subtitle ?? '' }}
                    </h3>
                    <hr class="my-4">

                    {{-- ส่วนเนื้อหา (ใช้ {!! !!} เพื่อแสดง HTML จาก Summernote) --}}
                    <div class="content-body" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! $page->content !!}
                    </div>

                    {{-- ส่วนรูปภาพท้ายเว็บ --}}
                    @if(!empty($page->images))
                    <div class="row g-4 mt-4">
                        @foreach($page->images as $img)
                        <div class="col-md-6">
                            <img src="{{ $img }}" class="img-fluid rounded shadow-sm w-100 hover-zoom">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="text-center mt-5">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                            &laquo; กลับหน้าแรก
                        </a>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
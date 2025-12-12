@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- ปุ่มย้อนกลับ --}}
            <a href="{{ route('board') }}" class="btn btn-light text-muted mb-4 rounded-pill">
                <i class="bi bi-arrow-left"></i> กลับหน้ารวม
            </a>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- 1. แก้ $page->title เป็น $post->title --}}
                    <h1 class="mb-2 text-center text-success fw-bold">{{ $post->title }}</h1>

                    {{-- 2. แก้ $page->subtitle เป็น $post->subtitle --}}
                    @if($post->subtitle)
                        <h4 class="text-muted text-center mb-4">{{ $post->subtitle }}</h4>
                    @endif
                    
                    <hr class="my-4">

                    {{-- 3. แก้ $page->content เป็น $post->content --}}
                    <div class="content-body" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! $post->content !!}
                    </div>

                    {{-- 4. แก้ $page->images เป็น $post->images --}}
                    @if(!empty($post->images))
                    <div class="row g-4 mt-4">
                        @foreach($post->images as $img)
                        <div class="col-md-6">
                            <img src="{{ $img }}" class="img-fluid rounded shadow-sm w-100 hover-zoom">
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
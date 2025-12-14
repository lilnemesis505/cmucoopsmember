@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success"><i class="bi bi-layers-fill"></i> โครงการต่างๆที่เข้าร่วมกับสหกรณ์</h2>
        <p class="text-muted">เลือกหัวข้อเพื่อดูรายละเอียดเพิ่มเติม</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($posts as $post)
        <div class="col">
            <a href="{{ route('board.show', $post->id) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm hover-card border-0">
                    <div style="height: 200px; overflow: hidden; border-radius: 10px 10px 0 0;" class="bg-light position-relative">
                        @if($post->cover_image)
                            <img src="{{ $post->cover_image }}?tr=w-400,h-300,c-maintain_ratio" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-secondary opacity-25">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-2">{{ $post->title }}</h5>
                        <p class="text-muted small text-truncate">{{ $post->subtitle }}</p>
                        <button class="btn btn-outline-success btn-sm rounded-pill mt-2 px-4">อ่านต่อ</button>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection
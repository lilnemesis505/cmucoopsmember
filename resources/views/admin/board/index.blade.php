@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-layers-fill"></i> จัดการหน้าผู้ถือหุ้น (Board)</h2>
    <a href="{{ route('admin.board.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg"></i> เพิ่มหัวข้อใหม่
    </a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($posts as $post)
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div style="height: 150px; background: #eee; overflow: hidden;" class="position-relative">
                @if($post->cover_image)
                    <img src="{{ $post->cover_image }}" class="w-100 h-100" style="object-fit: cover;">
                @else
                    <div class="d-flex justify-content-center align-items-center h-100 text-muted">No Cover</div>
                @endif
            </div>
            <div class="card-body">
                <h5 class="fw-bold text-truncate">{{ $post->title }}</h5>
                <p class="text-muted small text-truncate">{{ $post->subtitle }}</p>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.board.edit', $post->id) }}" class="btn btn-warning btn-sm w-100"><i class="bi bi-pencil"></i> แก้ไข</a>
                    <form action="{{ route('admin.board.destroy', $post->id) }}" method="POST" class="w-100" onsubmit="return confirm('ยืนยันการลบ?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm w-100"><i class="bi bi-trash"></i> ลบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@extends('layouts.admin')

@section('content')

<h1 class="mb-4">จัดการสไลด์และแบนเนอร์</h1>

{{-- ================= ส่วนสไลด์หลัก ================= --}}
<div class="card shadow-sm mb-5">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-images me-2"></i> สไลด์โชว์หลัก (Slide)</h4>
    </div>
    <div class="card-body">
        
        {{-- ฟอร์มอัปโหลด Slide --}}
        <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded border">
            @csrf
            <input type="hidden" name="type" value="slide">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-bold">อัปโหลดสไลด์ใหม่:</label>
                    <input type="file" class="form-control" name="image" required accept="image/*">
                    <div class="form-text">แนะนำขนาด 1920x1080px</div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload me-1"></i> อัปโหลด
                    </button>
                </div>
            </div>
        </form>

        {{-- ตารางรายการ Slide --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 40%">รูปภาพตัวอย่าง</th>
                        <th>File ID</th>
                        <th style="width: 15%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slides as $index => $slide)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $slide->image_url }}?tr=w-250,h-120,c-auto" class="img-thumbnail shadow-sm">
                        </td>
                        <td><code class="text-muted">{{ $slide->file_id }}</code></td>
                        <td>
                            <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบสไลด์นี้?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="slide">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">ยังไม่มีสไลด์</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= ส่วนแบนเนอร์ข้าง ================= --}}
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="bi bi-layout-sidebar-inset-reverse me-2"></i> แบนเนอร์ด้านข้าง (Banner)</h4>
    </div>
    <div class="card-body">
        
        {{-- ฟอร์มอัปโหลด Banner --}}
        @if($banners->count() >= 2)
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>ครบจำนวนแล้ว!</strong> <br>
                    มีแบนเนอร์ครบ 2 รูปแล้ว หากต้องการเพิ่มใหม่ กรุณาลบของเก่าออกก่อน
                </div>
            </div>
        @else
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded border">
                @csrf
                <input type="hidden" name="type" value="banner">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">อัปโหลดแบนเนอร์ใหม่ (สูงสุด 2 รูป):</label>
                        <input type="file" class="form-control" name="image" required accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-upload me-1"></i> อัปโหลด
                        </button>
                    </div>
                </div>
            </form>
        @endif

        {{-- ตารางรายการ Banner --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 40%">รูปภาพตัวอย่าง</th>
                        <th>File ID</th>
                        <th style="width: 15%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $index => $banner)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $banner->image_url }}?tr=w-250,h-120,c-auto" class="img-thumbnail shadow-sm">
                        </td>
                        <td><code class="text-muted">{{ $banner->file_id }}</code></td>
                        <td>
                            <form action="{{ route('admin.slides.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบแบนเนอร์นี้?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="banner">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">ยังไม่มีแบนเนอร์</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
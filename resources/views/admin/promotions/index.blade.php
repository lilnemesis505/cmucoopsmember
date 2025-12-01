@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-megaphone-fill"></i> จัดการปกสิทธิประโยชน์</h2>

    {{-- Form คลุมทั้งหมด --}}
    <form action="{{ route('admin.promotions.update_all') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($promotions as $promo)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">
                        ลำดับที่ {{ $promo->id }}
                        
                        {{-- Hidden Input เพื่อส่ง ID --}}
                        <input type="hidden" name="promotions[{{ $promo->id }}][id]" value="{{ $promo->id }}">
                    </div>
                    <div class="card-body">
                        
                        {{-- รูปภาพ --}}
                        <div class="mb-3 text-center">
                            @if($promo->image_url)
                                <img src="{{ $promo->image_url }}?tr=h-200" class="img-fluid rounded mb-2" style="max-height: 200px;">
                            @else
                                <div class="bg-light p-4 rounded text-muted">ไม่มีรูปภาพ</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">เปลี่ยนรูปภาพ</label>
                            <input type="file" name="promotions[{{ $promo->id }}][image]" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">หัวข้อหลัก (Main Title)</label>
                            <input type="text" name="promotions[{{ $promo->id }}][main_title]" class="form-control" value="{{ $promo->main_title }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">รายละเอียดรอง (Subtitle)</label>
                            <textarea name="promotions[{{ $promo->id }}][subtitle]" class="form-control" rows="3">{{ $promo->subtitle }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ปุ่มบันทึก (แก้ไขใหม่: อยู่ล่างสุดของเนื้อหา ตรงกลาง ไม่ Fixed) --}}
        <div class="row mt-4 mb-5">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                    <i class="bi bi-save"></i> บันทึกข้อมูลทั้งหมด
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
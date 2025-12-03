@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm mb-3">&laquo; กลับไปหน้ารวม Events</a>

<h1 class="mb-4">จัดการ Event: <span class="text-primary">{{ $key }}</span></h1>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> แก้ไขรายละเอียด</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.update_details', $key) }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">หัวข้อ:</label>
                <input type="text" class="form-control" name="event_title" value="{{ $event->title }}" placeholder="ระบุชื่อกิจกรรม...">
            </div>

            {{-- [เพิ่มใหม่] ช่องเลือกวันที่ --}}
            <div class="mb-3">
                <label class="form-label fw-bold">วันที่จัดกิจกรรม:</label>
                <input type="date" class="form-control" name="event_date" value="{{ $event->event_date }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">รายละเอียด:</label>
                <textarea class="form-control" name="event_description" rows="5" placeholder="ใส่รายละเอียดเนื้อหาข่าว...">{{ $event->description }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> บันทึกข้อมูล
            </button>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0"><i class="bi bi-cloud-upload"></i> อัปโหลดรูปภาพ</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.upload', $key) }}" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="event_image" required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> อัปโหลด
                </button>
            </div>
            <small class="text-muted">* รองรับไฟล์รูปภาพ jpg, png, jpeg</small>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0"><i class="bi bi-images"></i> รูปภาพในอัลบั้ม</h4>
    </div>
    <div class="card-body">
        @if($images->isEmpty())
            <div class="text-center py-4 text-muted">
                ยังไม่มีรูปภาพในอัลบั้มนี้
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 150px;">รูปภาพ</th>
                            <th>ลิงก์ไฟล์ (ImageKit)</th>
                            <th style="width: 100px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($images as $img)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $img->image_url }}?tr=w-100,h-100,c-maintain_ratio" class="img-thumbnail rounded" style="max-height: 80px;">
                            </td>
                            <td>
                                <a href="{{ $img->image_url }}" target="_blank" class="text-decoration-none text-truncate d-block" style="max-width: 300px;">
                                    {{ $img->image_url }}
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.events.delete_image', $img->id) }}" onsubmit="return confirm('ยืนยันที่จะลบรูปภาพนี้ใช่หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="card shadow-sm mt-4 border-danger">
    <div class="card-header bg-danger text-white py-3">
    </div>
    <div class="card-body">
        <p class="text-muted small">
            ระบบจะทำการลบข้อมูลของ <strong>{{ $key }}</strong> ทั้งหมด (หัวข้อ, รายละเอียด, รูปภาพ) 
        </p>

       <form action="{{ route('admin.events.destroy', $key) }}" method="POST" onsubmit="return confirmDelete()">
    @csrf
    @method('DELETE') <button type="submit" class="btn btn-outline-danger w-100">
        <i class="bi bi-trash"></i> ลบกิจกรรม
</form>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm("คุณแน่ใจหรือไม่ที่จะลบ {{ $key }}?\n\nการกระทำนี้ไม่สามารถเรียกคืนได้ และข้อมูลลำดับถัดไปจะถูกเลื่อนขึ้นมาแทนที่ทันที");
    }
</script>
</div>
@endsection
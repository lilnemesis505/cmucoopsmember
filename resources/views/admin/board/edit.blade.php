@extends('layouts.admin')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&family=Mali:wght@400;600&family=Chakra+Petch:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* ... (CSS เหมือนหน้า Create) ... */
    .note-editor .note-toolbar { background: #f1f5f9; position: sticky; top: 0; z-index: 50; }
    .note-editable { background: #fff; font-family: 'Sarabun', sans-serif; font-size: 16px; min-height: 400px; }
    .card-section { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; margin-bottom: 25px; overflow: hidden; }
    .section-header { background: #f8fafc; padding: 12px 20px; border-bottom: 1px solid #eef2f5; font-weight: 600; color: #334155; }
    
    /* Style สำหรับรูปภาพ Gallery */
    .gallery-preview { position: relative; height: 100px; overflow: hidden; border-radius: 8px; cursor: pointer; border: 2px solid transparent; }
    .gallery-check { position: absolute; top: 5px; right: 5px; z-index: 10; }
    .del-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background:rgba(220,53,69,0.7); display:none; align-items:center; justify-content:center; color:#fff; font-weight:bold; }
    input[type="checkbox"]:checked ~ .del-overlay { display: flex; }
</style>

<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-warning"></i> แก้ไขข้อมูล: {{ $post->title }}</h2>
        <a href="{{ route('admin.board.index') }}" class="btn btn-light border rounded-pill px-4">ยกเลิก</a>
    </div>

    <form action="{{ route('admin.board.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                {{-- 1. ข้อมูลทั่วไป --}}
                <div class="card-section">
                    <div class="section-header">ข้อมูลพื้นฐาน</div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">หัวข้อหลัก</label>
                            <input type="text" name="title" class="form-control form-control-lg" value="{{ $post->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">หัวข้อรอง</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ $post->subtitle }}">
                        </div>
                    </div>
                </div>

                {{-- 2. เนื้อหา --}}
                <div class="card-section">
                    <div class="section-header">เนื้อหาละเอียด</div>
                    <div class="p-0">
                        <textarea id="summernote" name="content">{{ $post->content }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- 3. รูปปก --}}
                <div class="card-section">
                    <div class="section-header">รูปปก (Cover)</div>
                    <div class="p-3 text-center">
                        @if($post->cover_image)
                            <div class="mb-2">
                                <img src="{{ $post->cover_image }}" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                            </div>
                        @else
                            <div class="bg-light border rounded p-3 mb-2 text-muted">ไม่มีรูปปก</div>
                        @endif
                        <label class="form-label small fw-bold">เปลี่ยนรูปปกใหม่:</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                    </div>
                </div>

                {{-- 4. แกลเลอรี --}}
                <div class="card-section">
                    <div class="section-header">รูปประกอบ (Gallery)</div>
                    <div class="p-3">
                        
                        @if(!empty($post->images))
                            <p class="small text-muted mb-2">เลือกรูปที่ต้องการ <strong>ลบ</strong>:</p>
                            <div class="row g-2 mb-3">
                                @foreach($post->images as $img)
                                <div class="col-4">
                                    <label class="gallery-preview w-100">
                                        <img src="{{ $img }}" class="w-100 h-100 object-fit-cover">
                                        <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="gallery-check form-check-input">
                                        <div class="del-overlay"><i class="bi bi-trash"></i> ลบ</div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <label class="form-label small fw-bold">เพิ่มรูปใหม่:</label>
                        <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-warning w-100 py-3 rounded-3 fw-bold shadow-sm text-dark">
                    <i class="bi bi-save-fill"></i> บันทึกการแก้ไข
                </button>
            </div>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'รายละเอียดเนื้อหา...',
        tabsize: 2, height: 400,
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        fontNames: ['Sarabun', 'Mali', 'Chakra Petch', 'Arial'],
        fontNamesIgnoreCheck: ['Sarabun', 'Mali', 'Chakra Petch']
    });
</script>

@endsection
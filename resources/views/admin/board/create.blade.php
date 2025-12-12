@extends('layouts.admin')

@section('content')

{{-- Load CSS --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&family=Mali:wght@400;600&family=Chakra+Petch:wght@400;600&display=swap" rel="stylesheet">

<style>
    .note-editor .note-toolbar { background: #f1f5f9; position: sticky; top: 0; z-index: 50; }
    .note-editable { background: #fff; font-family: 'Sarabun', sans-serif; font-size: 16px; min-height: 300px; }
    .card-section { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; margin-bottom: 25px; overflow: hidden; }
    .section-header { background: #f8fafc; padding: 12px 20px; border-bottom: 1px solid #eef2f5; font-weight: 600; color: #334155; }
</style>

<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill text-success"></i> เพิ่มหัวข้อสิทธิประโยชน์ใหม่</h2>
        <a href="{{ route('admin.board.index') }}" class="btn btn-light border rounded-pill px-4">ย้อนกลับ</a>
    </div>

    <form action="{{ route('admin.board.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            {{-- ฝั่งซ้าย: ข้อมูลหลัก --}}
            <div class="col-lg-8">
                {{-- 1. ข้อมูลทั่วไป --}}
                <div class="card-section">
                    <div class="section-header"><i class="bi bi-info-circle"></i> ข้อมูลพื้นฐาน</div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">หัวข้อหลัก (Title) <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" required placeholder="หัวข้อหลัก">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">คำโปรย / หัวข้อรอง (Subtitle)</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="หัวข้อรอง">
                        </div>
                    </div>
                </div>

                {{-- 2. เนื้อหา (Summernote) --}}
                <div class="card-section">
                    <div class="section-header"><i class="bi bi-file-text"></i> เนื้อหาละเอียด</div>
                    <div class="p-0">
                        <textarea id="summernote" name="content"></textarea>
                    </div>
                </div>
            </div>

            {{-- ฝั่งขวา: รูปภาพ --}}
            <div class="col-lg-4">
                {{-- 3. รูปปก (Cover) --}}
                <div class="card-section">
                    <div class="section-header"><i class="bi bi-image"></i> รูปปก (Cover Image)</div>
                    <div class="p-3 text-center">
                        <div class="bg-light border rounded p-3 mb-2">
                            <i class="bi bi-image display-4 text-secondary"></i>
                            <p class="small text-muted mb-0">แสดงหน้ารวม (Grid)</p>
                        </div>
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                    </div>
                </div>

                {{-- 4. แกลเลอรี (Gallery) --}}
                <div class="card-section">
                    <div class="section-header"><i class="bi bi-images"></i> รูปประกอบเพิ่มเติม (ท้ายเรื่อง)</div>
                    <div class="p-3">
                        <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted d-block mt-2">เลือกได้หลายรูป (สำหรับแสดงเป็นอัลบั้มด้านล่างเนื้อหา)</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold shadow-sm">
                    <i class="bi bi-save-fill"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>

    </form>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'รายละเอียดเนื้อหา...',
        tabsize: 2,
        height: 400,
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        fontNames: ['Sarabun', 'Mali', 'Chakra Petch', 'Arial', 'Courier New'],
        fontNamesIgnoreCheck: ['Sarabun', 'Mali', 'Chakra Petch']
    });
</script>

@endsection
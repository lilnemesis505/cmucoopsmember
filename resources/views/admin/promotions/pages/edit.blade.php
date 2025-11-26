@extends('layouts.admin')

@section('content')

{{-- 1. เรียกใช้ CSS ของ Summernote (Lite Version) โดยตรงที่นี่เพื่อแก้ปัญหาจอเพี้ยน --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    /* ปรับแต่งเพิ่มเติมให้ดูสะอาดตา */
    .note-editor .note-toolbar {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .img-preview-box {
        position: relative;
        display: inline-block;
        border: 2px dashed #ddd;
        padding: 5px;
        border-radius: 8px;
    }
    .btn-delete-img {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        text-align: center;
        line-height: 24px;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>

<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-primary">
                <i class="bi bi-pencil-square"></i> แก้ไขหน้า: <span class="text-dark text-capitalize">{{ $key }}</span>
            </h2>
            <p class="text-muted mb-0">จัดการข้อมูลหัวข้อ เนื้อหา และรูปภาพของหน้านี้</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            
            <form action="{{ route('admin.pages.update', $key) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- โซนข้อมูลหลัก --}}
                    <div class="col-md-12">
                        <div class="bg-light p-3 rounded border mb-3">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-fonts"></i> ส่วนหัวข้อ (Header)</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">หัวข้อหลัก (Main Title)</label>
                                    <input type="text" name="title" class="form-control form-control-lg" value="{{ $page->title }}" placeholder="ใส่หัวข้อใหญ่ที่นี่...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">หัวข้อรอง (Subtitle)</label>
                                    <input type="text" name="subtitle" class="form-control form-control-lg" value="{{ $page->subtitle }}" placeholder="ใส่คำอธิบายสั้นๆ...">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- โซนเนื้อหา (Summernote) --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold h5 mb-2"><i class="bi bi-file-text"></i> เนื้อหาหลัก (Content)</label>
                        <textarea id="summernote" name="content">{{ $page->content }}</textarea>
                    </div>

                    <div class="col-12"><hr></div>

                    {{-- โซนรูปภาพ --}}
                    <div class="col-md-12">
                        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-images"></i> แกลเลอรีรูปภาพ (ท้ายเว็บ)</h5>
                        
                        {{-- แสดงรูปเดิม --}}
                        @if(!empty($page->images))
                            <div class="mb-3">
                                <label class="form-label text-muted small">รูปภาพปัจจุบัน (ติ๊กเลือกเพื่อลบ)</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($page->images as $index => $img)
                                    <div class="img-preview-box">
                                        <img src="{{ $img }}?tr=w-150,h-150,c-maintain_ratio" class="rounded" style="height: 100px;">
                                        <label class="btn-delete-img" for="del_img_{{ $index }}">
                                            <i class="bi bi-x"></i>
                                        </label>
                                        {{-- Checkbox ซ่อนไว้ --}}
                                        <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_img_{{ $index }}" style="display:none;" onchange="this.parentElement.style.opacity = this.checked ? '0.3' : '1'">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- อัปโหลดใหม่ --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">อัปโหลดรูปเพิ่ม</label>
                            <input type="file" name="upload_images[]" class="form-control" multiple accept="image/*">
                            <div class="form-text">สามารถเลือกได้หลายรูปพร้อมกัน (รองรับ jpg, png, jpeg)</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow">
                        <i class="bi bi-save"></i> บันทึกการแก้ไขทั้งหมด
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- 2. เรียกใช้ Script --}}
{{-- jQuery (จำเป็นสำหรับ Summernote) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Summernote JS --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'พิมพ์รายละเอียดเนื้อหาที่นี่... คุณสามารถจัดหน้า ใส่ตัวหนา ตัวเอียง หรือรายการได้',
            tabsize: 2,
            height: 400, // กำหนดความสูง Editor
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            // ปรับแต่งฟอนต์ให้รองรับภาษาไทย
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Prompt', 'Sarabun'],
            fontNamesIgnoreCheck: ['Prompt', 'Sarabun']
        });
    });
</script>

@endsection
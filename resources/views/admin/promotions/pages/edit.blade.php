@extends('layouts.admin')

@section('content')

{{-- 1. Load CSS --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
{{-- โหลดฟอนต์ไทยสวยๆ มาให้เลือกใช้ --}}
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&family=Mali:wght@400;600&family=Chakra+Petch:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* --- Summernote Customization --- */
    .note-editor .note-toolbar {
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 50; /* Toolbar ลอยตามเวลาเลื่อนอ่าน */
    }
    .note-editable {
        background: #fff;
        font-family: 'Prompt', sans-serif; /* ฟอนต์เริ่มต้น */
        font-size: 16px;
        line-height: 1.6;
    }

    /* --- General UI --- */
    .card-section {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
        margin-bottom: 30px;
        overflow: hidden;
    }
    .section-header {
        background: #f8fafc;
        padding: 15px 25px;
        border-bottom: 1px solid #eef2f5;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* --- Image Gallery Manager --- */
    .gallery-item {
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
    }
    .gallery-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid transparent;
        transition: all 0.2s;
    }
    /* Checkbox ซ่อนไว้ */
    .gallery-checkbox {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    /* สถานะเมื่อเลือกรูปเพื่อลบ */
    .gallery-checkbox:checked + img {
        border-color: #ef4444; /* ขอบแดง */
        opacity: 0.5;
        filter: grayscale(100%);
    }
    .gallery-checkbox:checked ~ .delete-overlay {
        display: flex;
    }
    .delete-overlay {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ef4444;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        pointer-events: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }

    /* --- Sticky Bottom Bar --- */
    .sticky-footer {
        position: fixed;
        bottom: 0;
        left: 0; /* ระวังทับ Sidebar ถ้า Sidebar ไม่ได้ Fixed */
        right: 0;
        background: white;
        padding: 15px 40px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
        z-index: 1000;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
        /* ปรับ left ตามความกว้าง Sidebar ถ้ามี */
        /* ถ้าใช้ layout ปกติของ Admin ส่วนใหญ่ wrapper จะจัดการให้ */
    }
    /* ดันเนื้อหาขึ้นมาไม่ให้โดนบัง */
    .main-content-wrapper {
        padding-bottom: 100px;
    }
</style>

<div class="container-fluid py-4 main-content-wrapper">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">
                <i class="bi bi-pencil-fill text-primary"></i> แก้ไขหน้า: <span class="text-primary text-capitalize">{{ $key }}</span>
            </h2>
            <p class="text-muted mb-0">ปรับแต่งเนื้อหา จัดรูปแบบข้อความ และจัดการรูปภาพ</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light border text-muted rounded-pill px-4">
            <i class="bi bi-x-lg"></i> ยกเลิก
        </a>
    </div>

    <form action="{{ route('admin.pages.update', $key) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- SECTION 1: ข้อมูลทั่วไป --}}
        <div class="card-section">
            <div class="section-header">
                <i class="bi bi-info-circle-fill text-info"></i> ข้อมูลส่วนหัว (Header)
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">หัวข้อหลัก (Main Title)</label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0" value="{{ $page->title }}" placeholder="ระบุหัวข้อเรื่อง...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">หัวข้อรอง (Subtitle)</label>
                        <input type="text" name="subtitle" class="form-control form-control-lg bg-light border-0" value="{{ $page->subtitle }}" placeholder="คำอธิบายสั้นๆ...">
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: เนื้อหา (Summernote) --}}
        <div class="card-section">
            <div class="section-header">
                <i class="bi bi-file-earmark-richtext-fill text-warning"></i> เนื้อหาหลัก (Content Editor)
            </div>
            <div class="p-0"> {{-- padding 0 เพื่อให้ Toolbar ชิดขอบ --}}
                <textarea id="summernote" name="content">{{ $page->content }}</textarea>
            </div>
        </div>

        {{-- SECTION 3: แกลเลอรีรูปภาพ --}}
        <div class="card-section">
            <div class="section-header">
                <i class="bi bi-images text-success"></i> แกลเลอรีรูปภาพ (ท้ายเว็บ)
            </div>
            <div class="p-4">
                
                {{-- รูปภาพเดิม --}}
             {{-- รูปภาพเดิม --}}
                @if(!empty($page->images))
                    <p class="fw-bold mb-3">รูปภาพปัจจุบัน <span class="text-danger fw-normal small">(กดที่ปุ่ม X เพื่อลบรูป)</span></p>
                    <div class="row g-3 mb-4">
                        @foreach($page->images as $index => $img)
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="position-relative border rounded p-1" id="img-box-{{ $index }}">
                                <img src="{{ $img }}?tr=w-200,h-200,c-maintain_ratio" class="w-100 rounded" style="height: 120px; object-fit: cover;">
                                
                                {{-- ปุ่มลบ (Checkbox ซ่อนอยู่ข้างใน) --}}
                                <div class="form-check position-absolute top-0 end-0 m-1">
                                    <input class="btn-check" type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_img_{{ $index }}" autocomplete="off" onchange="toggleDelete({{ $index }})">
                                    <label class="btn btn-sm btn-danger rounded-circle shadow-sm p-0" for="del_img_{{ $index }}" style="width: 24px; height: 24px; line-height: 22px;">
                                        <i class="bi bi-x"></i>
                                    </label>
                                </div>
                                
                                {{-- Overlay สีแดงเมื่อเลือก --}}
                                <div id="overlay-{{ $index }}" class="position-absolute top-0 start-0 w-100 h-100 bg-danger bg-opacity-50 rounded d-none flex-column justify-content-center align-items-center text-white fw-bold" style="pointer-events: none;">
                                    <i class="bi bi-trash-fill fs-3 mb-1"></i>
                                    <span>ลบ</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
                <hr class="my-4 text-muted opacity-25">

                {{-- อัปโหลดใหม่ --}}
                <div class="bg-light p-4 rounded-3 border border-dashed text-center">
                    <i class="bi bi-cloud-arrow-up display-4 text-primary mb-3 d-block"></i>
                    <label class="form-label fw-bold">อัปโหลดรูปภาพเพิ่ม</label>
                    <div class="col-md-6 mx-auto">
                        <input type="file" name="upload_images[]" class="form-control" multiple accept="image/*">
                    </div>
                    <p class="text-muted small mt-2 mb-0">รองรับไฟล์ JPG, PNG, JPEG (เลือกได้หลายรูป)</p>
                </div>
            </div>
        </div>

        {{-- STICKY SAVE BAR (แถบบันทึก ลอยอยู่ด้านล่าง) --}}
        <div class="sticky-footer">
            <span class="text-muted small me-auto d-none d-md-block">
                <i class="bi bi-clock-history"></i> แก้ไขล่าสุดเมื่อ: {{ date('d/m/Y H:i') }}
            </span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-link text-decoration-none text-muted">ยกเลิก</a>
            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow fw-bold">
                <i class="bi bi-save-fill"></i> บันทึกการเปลี่ยนแปลง
            </button>
        </div>

    </form>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'เริ่มเขียนเนื้อหาที่นี่... กด Enter เพื่อขึ้นบรรทัดใหม่',
            tabsize: 2,
            height: 500, // เพิ่มความสูงให้เขียนสะดวก
            focus: true,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']], // เพิ่ม style (h1, h2, p)
                ['fontname', ['fontname']], // ✅ เพิ่มเมนูเลือกฟอนต์
                ['fontsize', ['fontsize']], // ✅ เพิ่มเมนูเลือกขนาด
                ['color', ['color']], // เลือกสี
                ['para', ['ul', 'ol', 'paragraph', 'height']], // จัดย่อหน้า + ความสูงบรรทัด
                ['insert', ['link', 'picture', 'video', 'table', 'hr']], // ✅ แทรกรูป/วิดีโอในเนื้อหาได้
                ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']] // ✅ มี undo/redo
            ],
            // กำหนดรายชื่อฟอนต์ที่จะโชว์ใน Dropdown
            fontNames: ['Prompt', 'Sarabun', 'Mali', 'Chakra Petch', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            fontNamesIgnoreCheck: ['Prompt', 'Sarabun', 'Mali', 'Chakra Petch'], // บังคับให้โชว์ฟอนต์ไทย
            
            // ปรับแต่ง UI เพิ่มเติม
            callbacks: {
                onInit: function() {
                    // ปรับปรุงหน้าตา Editor เล็กน้อย
                    $('.note-editable').css('font-size', '16px');
                }
            }
        });
    });
    function toggleDelete(index) {
        var checkbox = document.getElementById('del_img_' + index);
        var overlay = document.getElementById('overlay-' + index);
        
        if (checkbox.checked) {
            overlay.classList.remove('d-none');
            overlay.classList.add('d-flex');
        } else {
            overlay.classList.add('d-none');
            overlay.classList.remove('d-flex');
        }
    }
</script>

@endsection
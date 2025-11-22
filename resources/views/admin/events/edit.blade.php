@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm mb-3">&laquo; กลับไปหน้ารวม Events</a>

<h1 class="mb-4">จัดการ Event: {{ $key }}</h1>

<div class="card shadow-sm mb-4">
    <div class="card-header"><h3>แก้ไขรายละเอียด</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.update_details', $key) }}">
            @csrf
            <div class="mb-3">
                <label>หัวข้อ:</label>
                <input type="text" class="form-control" name="event_title" value="{{ $event->title }}">
            </div>
            <div class="mb-3">
                <label>รายละเอียด:</label>
                <textarea class="form-control" name="event_description" rows="5">{{ $event->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">บันทึก</button>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header"><h3>อัปโหลดรูปภาพ</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.upload', $key) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control" name="event_image" required>
            </div>
            <button type="submit" class="btn btn-primary">อัปโหลด</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header"><h3>รูปภาพในอัลบั้ม</h3></div>
    <div class="card-body">
        <table class="table table-striped">
            <tbody>
                @foreach($images as $img)
                <tr>
                    <td><img src="{{ $img->image_url }}?tr=w-100" class="img-thumbnail"></td>
                    <td>
                        <form method="POST" action="{{ route('admin.events.delete_image', $img->id) }}" onsubmit="return confirm('ยืนยันลบ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
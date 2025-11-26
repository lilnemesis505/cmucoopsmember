@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> สมัครสมาชิกใหม่</h4>
                </div>
                <div class="card-body p-4">

                    {{-- แสดง Error --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.register.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้ใช้ (Username)</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="ตั้งชื่อผู้ใช้">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">อีเมล (Email)</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="name@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">รหัสผ่าน (Password)</label>
                            <input type="password" name="password" class="form-control" required placeholder="อย่างน้อย 8 ตัวอักษร">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ยืนยันรหัสผ่าน (Confirm Password)</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="กรอกรหัสผ่านอีกครั้ง">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">ยืนยันการสมัคร</button>
                            <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary">กลับไปหน้าเข้าสู่ระบบ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
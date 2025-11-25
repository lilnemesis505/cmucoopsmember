@extends('layouts.app')

@section('content')

<div class="container mt-5"> 
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold">Admin Login</h3>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้ใช้ (Username)</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่าน (Password)</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember_me" id="remember">
                            <label class="form-check-label" for="remember">จดจำฉัน</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
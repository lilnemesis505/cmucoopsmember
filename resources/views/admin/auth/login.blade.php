<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card { width: 100%; max-width: 400px; border: none; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="card">
    <div class="card-body p-5">
        <h3 class="text-center mb-4 fw-bold">Admin Login</h3>

        {{-- แสดง Error ถ้า Login ไม่ผ่าน --}}
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

</body>
</html>
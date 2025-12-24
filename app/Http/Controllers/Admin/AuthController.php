<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล
        $request->validate([
            'name' => 'required|string|max:255|unique:users', // เช็คชื่อซ้ำ
            'email' => 'required|string|email|max:255|unique:users', // เช็คอีเมลซ้ำ
            'password' => 'required|string|min:8|confirmed', // password_confirmation ต้องตรงกัน
        ]);

        // 2. สร้าง User ใหม่ลง Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // เข้ารหัสรหัสผ่าน
        ]);

        // 3. ส่งกลับไปหน้า Login พร้อมข้อความ
        return redirect()->route('admin.login')->with('success', 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
    }

    public function showLogin()
{
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    // เปลี่ยนจาก view('admin.auth.login') เป็น:
    return \Inertia\Inertia::render('Admin/Auth/Login');
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required', // หรือ email
            'password' => 'required',
        ]);

        $remember = $request->has('remember_me');

        // ใช้ Auth ของ Laravel (ตาราง users หรือ admin ต้องมี field 'password' ที่ hash แล้ว)
        // ถ้าใช้ตาราง admin ต้องไปแก้ config/auth.php ให้ provider ชี้ไปที่ Admin Model
        if (Auth::attempt(['name' => $request->username, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
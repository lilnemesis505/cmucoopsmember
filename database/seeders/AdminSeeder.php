<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ตรวจสอบว่ามี user ชื่อ admin หรือยัง (ถ้ามีแล้วจะไม่สร้างซ้ำ)
        $admin = User::where('name', 'admin')->first();

        if (!$admin) {
            User::create([
                'name' => 'admin',                  // Username
                'email' => 'admin@example.com',     // Email (สมมติ)
                'password' => Hash::make('123456'), // Password (เปลี่ยนได้ตามใจชอบ)
            ]);
            echo "✅ Admin account created successfully.\n";
        } else {
            echo "⚠️ Admin account already exists.\n";
        }
    }
}
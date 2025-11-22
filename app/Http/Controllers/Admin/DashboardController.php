<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView; // สมมติว่ามี Model นี้

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงสถิติ (เหมือนโค้ดเดิม)
        $totalViews = 0; // PageView::where('page_url', 'index.php')->count();
        
        return view('admin.dashboard', compact('totalViews'));
    }
}
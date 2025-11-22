<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Banner;
use App\Models\Event;
// use App\Models\PageView; // เอาออก หรือคอมเมนต์ไว้ถ้าไม่ได้ใช้แล้ว
use App\Models\EventImage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // --- ส่วนบันทึก Traffic ถูกลบออกแล้ว ---

        // 1. ดึงข้อมูล Slide และ Banner
        $slides = Slide::orderBy('id', 'asc')->get();
        $banners = Banner::orderBy('id', 'asc')->limit(2)->get();

        // เตรียม Banner URL (ถ้าไม่มีใส่ Placeholder)
        $banner1 = $banners->get(0)->image_url ?? 'https://via.placeholder.com/400x200.png?text=Side+Banner+1';
        $banner2 = $banners->get(1)->image_url ?? 'https://via.placeholder.com/400x200.png?text=Side+Banner+2';

        // 2. ดึงข้อมูล Event พร้อมรูปปก
        $events = Event::whereIn('key', ['ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'])
                       ->with('coverImage')
                       ->get();

        return view('home', compact('slides', 'banner1', 'banner2', 'events'));
    }

    public function member()
    {
        return view('pages.member');
    }

    public function board()
    {
        return view('pages.board');
    }
    public function showEvent($key)
    {
        // 1. ค้นหา Event จาก key (ev1, ev2, ...)
        // ถ้าไม่เจอจะเด้งหน้า 404 ให้เอง (firstOrFail)
    $event = Event::where('key', $key)->with('images')->firstOrFail();

    // ส่งตัวแปร $event ไปที่หน้า View
    return view('pages.event_detail', compact('event'));
    }
    
}
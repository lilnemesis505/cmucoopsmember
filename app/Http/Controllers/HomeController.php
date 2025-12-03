<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Banner;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Promotion; // เรียกใช้ Model Promotion

class HomeController extends Controller
{
   public function index(Request $request)
{
    // 1. ดึงข้อมูล Slide และ Banner
    $slides = Slide::orderBy('id', 'asc')->get();
    $banners = Banner::orderBy('id', 'asc')->limit(2)->get();

    $banner1 = $banners->get(0)->image_url ?? 'https://via.placeholder.com/400x200.png?text=Side+Banner+1';
    $banner2 = $banners->get(1)->image_url ?? 'https://via.placeholder.com/400x200.png?text=Side+Banner+2';

    // --- [จุดที่แก้ไข] ---
    // ดึง Event ทั้งหมดที่มี พร้อมรูปปก
    $eventsRaw = Event::with('coverImage')->get();

    // เรียงลำดับเอง เพราะถ้าใช้ Database sort 'ev10' จะมาก่อน 'ev2'
    $events = $eventsRaw->sortBy(function($event) {
        // ตัดคำว่า 'ev' ออกแล้วแปลงเป็นตัวเลขเพื่อเรียงลำดับ
        return (int) str_replace('ev', '', $event->key);
    });
    // ------------------

    // 3. ดึงข้อมูล Promotion
    $promotions = Promotion::all();

    return view('home', compact('slides', 'banner1', 'banner2', 'events', 'promotions'));
}

   public function member()
{
    $page = \App\Models\PageContent::where('page_key', 'member')->first();
    // แก้ให้ชี้ไปที่ folder 'pages' ปกติ
    return view('pages.member', compact('page')); 
}

    public function board()
    {
        // ดึงข้อมูลหน้า board
        $page = \App\Models\PageContent::where('page_key', 'board')->first();
        return view('pages.board', compact('page'));
    }

    public function showEvent($key)
    {
        // 1. ค้นหา Event จาก key (ev1, ev2, ...)
        $event = Event::where('key', $key)->with('images')->firstOrFail();

        // ส่งตัวแปร $event ไปที่หน้า View รายละเอียด
        return view('pages.event_detail', compact('event'));
    }
    
}
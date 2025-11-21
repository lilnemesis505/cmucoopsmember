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
    public function setupData()
    {
        // 1. สร้าง Slide (ถ้ายังไม่มี)
        if (Slide::count() == 0) {
            Slide::create(['image_url' => 'https://via.placeholder.com/800x400/007bff/ffffff?text=Slide+1']);
            Slide::create(['image_url' => 'https://via.placeholder.com/800x400/28a745/ffffff?text=Slide+2']);
            Slide::create(['image_url' => 'https://via.placeholder.com/800x400/dc3545/ffffff?text=Slide+3']);
        }

        // 2. สร้าง Banner ข้างๆ (ถ้ายังไม่มี)
        if (Banner::count() == 0) {
            Banner::create(['image_url' => 'https://via.placeholder.com/400x200/ffc107/000000?text=Side+Banner+1']);
            Banner::create(['image_url' => 'https://via.placeholder.com/400x200/17a2b8/ffffff?text=Side+Banner+2']);
        }

        // 3. สร้าง Events (ev1 - ev6) และรูปภาพประกอบ
        $eventKeys = ['ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'];

        foreach ($eventKeys as $index => $key) {
            // ตรวจสอบว่ามี Event นี้หรือยัง ถ้าไม่มีให้สร้างใหม่
            $event = Event::firstOrCreate(
                ['key' => $key], // ค้นหาจาก key
                [
                    'title' => "กิจกรรมที่ " . ($index + 1) . " ($key)",
                    'description' => "รายละเอียดจำลองสำหรับกิจกรรม $key \nนี่คือตัวอย่างข้อความยาวๆ เพื่อทดสอบการแสดงผล..."
                ]
            );

            // ถ้า Event นี้ยังไม่มีรูป ให้เพิ่มรูปตัวอย่างเข้าไป 3 รูป
            if ($event->images()->count() == 0) {
                $event->images()->create(['image_url' => 'https://via.placeholder.com/600x400?text=Photo+1+for+' . $key]);
                $event->images()->create(['image_url' => 'https://via.placeholder.com/600x400?text=Photo+2+for+' . $key]);
                $event->images()->create(['image_url' => 'https://via.placeholder.com/600x400?text=Photo+3+for+' . $key]);
            }
        }

        return "<h1>✅ ติดตั้งข้อมูลจำลองเสร็จเรียบร้อย!</h1> <p><a href='/'>กลับหน้าแรก</a></p>";
    }
}
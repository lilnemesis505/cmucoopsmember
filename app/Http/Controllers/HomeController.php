<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageContent; // 1. เรียกใช้ Model นี้
use Inertia\Inertia;
use App\Models\EasyPointPost;
use App\Models\Event;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // เรียกไฟล์ Home.vue (ที่เป็นหน้าทางแยกสวยๆ)
        return Inertia::render('Home'); 
    }
    public function xcademy()
    {
        // ดึง Event ทั้งหมด พร้อมรูปภาพ
        // เรียงตามวันที่ล่าสุด หรือตาม Key ก็ได้
        $events = Event::with('images')
            ->orderBy('key', 'desc') // หรือ orderBy('event_date', 'desc')
            ->get();
        $sliders = Banner::where('type', 'slider')->latest()->get();
         $staticBanner = Banner::where('type', 'static')->first();

        return Inertia::render('HomeXcademy', [
            'events' => $events,
            'sliders' => $sliders,       // <--- ส่งไปหน้าบ้าน
            'staticBanner' => $staticBanner
        ]);
    }
    public function memberHome()
    {
        // 2. ดึงข้อมูล 3 ตัวตาม Page Key
        $targetKeys = ['member', 'board', 'ezpoint'];
        
        $contents = PageContent::whereIn('page_key', $targetKeys)
            ->orderBy('id', 'asc') // เรียงตาม ID (1, 2, 3)
            ->get();

        // 3. แปลงข้อมูลให้หน้าบ้านใช้ง่ายๆ
        $cards = $contents->map(function ($item) {
            // แกะรูปภาพ (เพราะใน DB เก็บเป็น JSON Array ["url"])
            $images = $item->images;
            if (is_string($images)) {
                $images = json_decode($images, true);
            }
            $mainImage = $images[0] ?? 'https://via.placeholder.com/800x400';

            // กำหนดลิ้งค์แยกตาม page_key
            $link = '#';
            if ($item->page_key === 'member') $link = route('member');
            elseif ($item->page_key === 'board') $link = route('board');
            elseif ($item->page_key === 'ezpoint') $link = '#'; // ยังไม่มี Route ezpoint ให้ใส่ # ไว้ก่อน

            return [
                'id' => $item->id,
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'image_url' => $mainImage,
                'link' => $link
            ];
        });

        return Inertia::render('HomeMember', [
            'cards' => $cards, // ส่งไปในชื่อ cards
            'title' => 'CMUCOOPMEMBER',
        ]);
    }

    // --- เมนูอื่นๆ คงเดิม ---
   public function member()
    {
        // 1. ดึงข้อมูล
        $page = \App\Models\PageContent::where('page_key', 'member')->firstOrFail();
        
        // 2. [แก้ตรงนี้] เอาคอมเมนต์ออก เพื่อแปลง JSON เป็น Array
        if (is_string($page->images)) {
            $page->images = json_decode($page->images, true) ?? [];
        }

        // 3. ส่งไปหน้า Member.vue
        return Inertia::render('Member/Member', [
            'page' => $page
        ]); 
    }

    public function board()
    {
        // ดึงข้อมูลล่าสุด
        $posts = \App\Models\BoardPost::latest()->get();
        
        // ส่งไปหน้า Vue BoardIndex
        return Inertia::render('Member/BoardIndex', [
            'posts' => $posts
        ]);
    }

    public function showBoard($id)
    {
        $post = \App\Models\BoardPost::findOrFail($id);

        // [สำคัญ!] แปลง JSON รูปภาพเป็น Array (กัน error จอขาว)
        if (is_string($post->images)) {
            $post->images = json_decode($post->images, true) ?? [];
        }

        // ส่งไปหน้า Vue BoardShow
        return Inertia::render('Member/BoardShow', [
            'post' => $post
        ]);
    }
   public function checkMember(Request $request)
    {
        // 1. รับค่า
        $member_id  = $request->input('member_id');
        $id_card    = $request->input('id_card');
        $first_name = $request->input('first_name');
        $last_name  = $request->input('last_name');
        $phone      = $request->input('phone');

        // 2. เช็คสถานะการค้นหา
        $hasSearch = $member_id || $id_card || $first_name || $last_name || $phone;
        
        $members = null;

        if ($hasSearch) {
            $query = \App\Models\Member::query();

            if ($member_id)  $query->where('member_id', 'like', "%{$member_id}%");
            if ($id_card)    $query->where('id_card', 'like', "%{$id_card}%");
            if ($first_name) $query->where('first_name', 'like', "%{$first_name}%");
            if ($last_name)  $query->where('last_name', 'like', "%{$last_name}%");
            if ($phone)      $query->where('phone', 'like', "%{$phone}%");

            $members = $query->paginate(10)->withQueryString();
        } else {
            $members = [
                'data' => [],
                'links' => [],
                'total' => 0
            ];
        }

        // 3. ส่งข้อมูล (สังเกตว่าไม่มี 'page' => $page)
        return Inertia::render('Member/CheckMember', [
            'members'   => $members,
            'filters'   => $request->all(),
            'hasSearch' => (bool)$hasSearch
        ]);
    }
        public function import(Request $request) 
    {
       // ... (ใช้โค้ดเดิมของคุณได้เลย)
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MembersImport, $request->file('file'));
            return back()->with('success', 'นำเข้าข้อมูลสมาชิกเรียบร้อยแล้ว!');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
    public function easyPoint()
    {
        // ดึงข้อมูลล่าสุด
        $posts = EasyPointPost::latest()->get();
        
        return Inertia::render('Member/EasyPointIndex', [
            'posts' => $posts
        ]);
    }

    // 2. หน้าอ่านรายละเอียด Easy Point
    public function showEasyPoint($id)
    {
        $post = EasyPointPost::findOrFail($id);
        
        // (ถ้าใน Model ใส่ protected $casts แล้ว ไม่ต้อง json_decode ตรงนี้ก็ได้ แต่ใส่กันเหนียวไว้ไม่เสียหาย)
        if (is_string($post->images)) {
            $post->images = json_decode($post->images, true) ?? [];
        }

        return Inertia::render('Member/EasyPointShow', [
            'post' => $post
        ]);
    }
}
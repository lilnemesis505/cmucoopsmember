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
        // 1. ดึงข้อมูลจาก Database
        $memberPage = PageContent::where('page_key', 'member')->first();
        $boardPage = PageContent::where('page_key', 'board')->first();
        $ezPage = PageContent::where('page_key', 'ezpoint')->first();

        // 2. สร้างข้อมูล Cards ส่งไปหน้าบ้าน
        $cards = [
            [
                'id' => 1,
                'title' => $memberPage->title ?? 'สิทธิประโยชน์สำหรับสมาชิก',
                'subtitle' => $memberPage->subtitle ?? 'ข้อมูลสมาชิก',
                // แก้ไข Logic: ให้ใช้ image_url (รูปปกใหม่) ก่อน ถ้าไม่มีค่อยใช้ images[0] (รูปเก่า)
                'image_url' => $memberPage->image_url ?? ($memberPage->images[0] ?? null),
                'link' => route('member')
            ],
            [
                'id' => 2,
                'title' => $boardPage->title ?? 'สิทธิประโยชน์รักษาพยาบาล',
                'subtitle' => $boardPage->subtitle ?? 'สวัสดิการ',
                'image_url' => $boardPage->image_url ?? ($boardPage->images[0] ?? null),
                'link' => route('board')
            ],
            [
                'id' => 3,
                'title' => $ezPage->title ?? 'สิทธิประโยชน์ Easy Point',
                'subtitle' => $ezPage->subtitle ?? 'Easy Point',
                'image_url' => $ezPage->image_url ?? ($ezPage->images[0] ?? null),
                'link' => route('easypoint')
            ],
        ];

        return Inertia::render('HomeMember', [
            'cards' => $cards,
            'title' => 'ระบบสมาชิกสหกรณ์'
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
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventImage;
use ImageKit\ImageKit;

class EventController extends Controller
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );
    }

    public function index()
    {
        return view('admin.events.index');
    }

    public function edit($key)
    {
        $event = Event::firstOrCreate(['key' => $key]);
        $images = $event->images()->orderBy('id', 'desc')->get();
        return view('admin.events.edit', compact('event', 'images', 'key'));
    }

    // --- ส่วนที่แก้ไข: เพิ่มการบันทึก event_date ---
    public function updateDetails(Request $request, $key)
    {
        $event = Event::where('key', $key)->firstOrFail();
        
        $event->update([
            'title' => $request->event_title,
            'description' => $request->event_description,
            'event_date' => $request->event_date, // <--- เพิ่มบรรทัดนี้
        ]);

        return back()->with('success', 'บันทึกรายละเอียดและวันที่สำเร็จ');
    }
    // ------------------------------------------

    public function uploadImage(Request $request, $key)
    {
        $request->validate(['event_image' => 'required|image']);
        $event = Event::where('key', $key)->firstOrFail();

        try {
            $file = $request->file('event_image');
            $upload = $this->imageKit->upload([
                'file' => fopen($file->getRealPath(), 'r'),
                'fileName' => $key . '_' . time(),
                'folder' => "/event/{$key}/"
            ]);

            $event->images()->create([
                'image_url' => $upload->result->url,
                'file_id' => $upload->result->fileId
            ]);

            return back()->with('success', 'อัปโหลดรูปภาพสำเร็จ');

        } catch (\Exception $e) {
            return back()->with('error', 'Upload Error: ' . $e->getMessage());
        }
    }

    public function deleteImage(Request $request, $id)
    {
        $image = EventImage::findOrFail($id);
        if ($image->file_id) {
            $this->imageKit->deleteFile($image->file_id);
        }
        $image->delete();
        return back()->with('warning', 'ลบรูปภาพสำเร็จ');
    }

   public function syncFromImageKit()
{
    // --- [จุดที่แก้ไข] ---
    // เปลี่ยนจาก Hardcode array มาเป็นการดึง Key ทั้งหมดที่มีอยู่ใน Database ปัจจุบัน
    // หรือถ้าอยากให้ Sync ตัวที่ยังไม่มีใน DB คุณอาจต้องใช้ listFolders ของ ImageKit API (ซึ่งซับซ้อนกว่า)
    // เบื้องต้นแนะนำให้ Sync ตามที่มีใน DB ที่เรา Create ไว้ครับ
    $events = Event::all(); 
    $totalSynced = 0;

    try {
        foreach ($events as $event) {
            $key = $event->key;
            
            // ตรวจสอบ Path ให้ตรงกับ ImageKit ของคุณ
            $folderPath = "/main/events/$key/"; 
            
            $files = $this->imageKit->listFiles([
                'path' => $folderPath,
                'limit' => 100
            ]);

            if (!empty($files->result)) {
                foreach ($files->result as $file) {
                    // เช็คว่ามี file_id นี้หรือยัง ป้องกันข้อมูลซ้ำ
                    $exists = EventImage::where('file_id', $file->fileId)->exists();
                    if (!$exists) {
                        EventImage::create([
                            'event_id' => $event->id,
                            'file_id' => $file->fileId,
                            'image_url' => $file->url,
                        ]);
                        $totalSynced++;
                    }
                }
            }
        }
        return back()->with('success', "ซิงค์ข้อมูลเสร็จสิ้น! ดึงรูปกลับมาได้ทั้งหมด $totalSynced รูป จากทุก Event");
    } catch (\Exception $e) {
        return back()->with('error', 'เกิดข้อผิดพลาดในการซิงค์: ' . $e->getMessage());
    }
}
    public function destroyEvent($key)
    {
        // 1. [แก้ไข] ดึง Keys ทั้งหมดจาก Database และเรียงลำดับให้ถูกต้อง (ev1, ev2, ..., ev10)
        $allEvents = Event::all()->sortBy(function($e) {
            return (int) str_replace('ev', '', $e->key);
        });
        
        // แปลงเป็น Array เช่น ['ev1', 'ev2', ..., 'ev7']
        $keys = $allEvents->pluck('key')->values()->toArray();
        $index = array_search($key, $keys);

        if ($index === false) {
            return back()->with('error', "ไม่พบ Event Key ($key) ในระบบ");
        }

        // 2. ลบข้อมูลและรูปภาพของ Event เป้าหมาย (เคลียร์ของเก่าก่อน)
        $targetEvent = Event::where('key', $key)->first();
        if ($targetEvent) {
            foreach ($targetEvent->images as $img) {
                if ($img->file_id) {
                    $this->imageKit->deleteFile($img->file_id);
                }
                $img->delete();
            }
            // ลบข้อความออก
            $targetEvent->update(['title' => null, 'description' => null, 'event_date' => null]);
        }

        // 3. ทำการเลื่อนข้อมูล (Shift Data)
        // วนลูปจากตัวที่ลบ ไปจนถึงตัวรองสุดท้าย
        for ($i = $index; $i < count($keys) - 1; $i++) {
            $currentKey = $keys[$i];     // ตัวปัจจุบัน (ที่ว่างอยู่)
            $nextKey = $keys[$i + 1];    // ตัวถัดไป (ที่จะเอามาเสียบ)

            $curr = Event::where('key', $currentKey)->first();
            $next = Event::where('key', $nextKey)->first();

            if ($curr && $next) {
                // ย้ายข้อความจาก Next -> Current
                $curr->update([
                    'title' => $next->title,
                    'description' => $next->description,
                    'event_date' => $next->event_date
                ]);

                // ย้ายรูปภาพ (เปลี่ยนเจ้าของ)
                foreach ($next->images as $image) {
                    $image->update(['event_id' => $curr->id]);
                }

                // เคลียร์ข้อมูลตัว Next หลังจากย้ายไปแล้ว
                $next->update(['title' => null, 'description' => null, 'event_date' => null]);
            }
        }

        // 4. [เพิ่มใหม่] ลบ Event ตัวสุดท้ายทิ้งไปเลย (Clean Up)
        // เพื่อให้จำนวนกิจกรรมลดลงจริงๆ ไม่เหลือเป็นช่องว่างท้ายตาราง
        $lastKey = $keys[count($keys) - 1];
        $lastEvent = Event::where('key', $lastKey)->first();
        
        // ถ้าตัวสุดท้ายว่างเปล่า (ไม่มีชื่อ) ให้ลบ Record ทิ้ง
        if ($lastEvent && empty($lastEvent->title)) {
            $lastEvent->delete();
        }

        return redirect()->route('admin.events.index')->with('success', "ลบข้อมูล $key และจัดเรียงลำดับใหม่เรียบร้อยแล้ว");
    }
    public function create()
    {
        // 1. หาเลข Key ล่าสุดที่มีอยู่ในระบบ
        // ดึง key ทั้งหมดมา เช่น ['ev1', 'ev2', 'ev10']
        $latestEvent = Event::select('key')->get()
            ->map(function ($event) {
                // ตัดคำว่า 'ev' ออก เหลือแต่ตัวเลข
                return (int) str_replace('ev', '', $event->key);
            })
            ->max(); // หาเลขที่มากที่สุด

        // ถ้าไม่มีเลย ให้เริ่มที่ 1, ถ้ามีแล้ว ให้บวก 1
        $nextId = $latestEvent ? $latestEvent + 1 : 1;
        $newKey = 'ev' . $nextId;

        // 2. สร้าง Event ใหม่
        Event::create([
            'key' => $newKey,
            'title' => "Event $newKey (สร้างใหม่)",
            'description' => null
        ]);

        return redirect()->route('admin.events.edit', $newKey)->with('success', "สร้างกิจกรรม $newKey เรียบร้อยแล้ว");
    }
}
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
        $eventKeys = ['ev1', 'ev2', 'ev3', 'ev4', 'ev5', 'ev6'];
        $totalSynced = 0;

        try {
            foreach ($eventKeys as $key) {
                $event = Event::firstOrCreate(['key' => $key], [
                    'title' => "Event $key", 'description' => "-"
                ]);

                // ตรวจสอบ Path ให้ตรงกับ ImageKit ของคุณ
                $folderPath = "/main/events/$key/"; 
                
                $files = $this->imageKit->listFiles([
                    'path' => $folderPath,
                    'limit' => 100
                ]);

                if (!empty($files->result)) {
                    foreach ($files->result as $file) {
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
            return back()->with('success', "ซิงค์ข้อมูลเสร็จสิ้น! ดึงรูปกลับมาได้ทั้งหมด $totalSynced รูป");
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการซิงค์: ' . $e->getMessage());
        }
    }
}
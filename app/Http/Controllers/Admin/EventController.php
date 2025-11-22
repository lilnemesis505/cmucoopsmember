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
        // แสดงรายการ ev1 - ev6 ให้เลือก
        return view('admin.events.index');
    }

    public function edit($key)
    {
        // หา Event จาก Key (เช่น ev1) ถ้าไม่มีสร้างใหม่รอไว้เลย
        $event = Event::firstOrCreate(['key' => $key]);
        
        // ดึงรูปภาพทั้งหมดของ event นี้
        $images = $event->images()->orderBy('id', 'desc')->get();

        return view('admin.events.edit', compact('event', 'images', 'key'));
    }

    public function updateDetails(Request $request, $key)
    {
        $event = Event::where('key', $key)->firstOrFail();
        $event->update([
            'title' => $request->event_title,
            'description' => $request->event_description
        ]);

        return back()->with('success', 'บันทึกรายละเอียดสำเร็จ');
    }

    public function uploadImage(Request $request, $key)
    {
        $request->validate(['event_image' => 'required|image']);
        $event = Event::where('key', $key)->firstOrFail();

        try {
            $file = $request->file('event_image');
            
            // Upload ImageKit
            $upload = $this->imageKit->upload([
                'file' => fopen($file->getRealPath(), 'r'),
                'fileName' => $key . '_' . time(),
                'folder' => "/event/{$key}/"
            ]);

            // Save DB (ตาราง event_images)
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

        // Delete from ImageKit
        if ($image->file_id) {
            $this->imageKit->deleteFile($image->file_id);
        }

        $image->delete();
        return back()->with('warning', 'ลบรูปภาพสำเร็จ');
    }
}
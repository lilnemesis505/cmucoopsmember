<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EasyPointPost; // <--- ใช้ Model ใหม่
use ImageKit\ImageKit;
use Inertia\Inertia;

class EasyPointPostController extends Controller
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
        // ดึงข้อมูลล่าสุด
        $posts = EasyPointPost::latest()->get();
        return Inertia::render('Admin/EasyPoint/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/EasyPoint/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'content' => 'nullable',
        ]);

        // 1. Cover Image
        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'ez_cover_' . time(),
                'folder' => '/easypoint/'
            ]);
            $data['cover_image'] = $upload->result->url;
        }

        // 2. Gallery Images
        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $up = $this->imageKit->upload([
                    'file' => fopen($file, 'r'),
                    'fileName' => 'ez_img_' . time(),
                    'folder' => '/easypoint/gallery/'
                ]);
                $gallery[] = $up->result->url;
            }
        }
        $data['images'] = $gallery;

        EasyPointPost::create($data);
        return redirect()->route('admin.easypoint.index')->with('success', 'เพิ่มโพสต์ Easy Point เรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $post = EasyPointPost::findOrFail($id);
        return Inertia::render('Admin/EasyPoint/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = EasyPointPost::findOrFail($id);
        $data = $request->except(['cover_image', 'gallery_images', 'remove_images']);

        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'ez_cover_' . time(),
                'folder' => '/easypoint/'
            ]);
            $data['cover_image'] = $upload->result->url;
        }

        $currentImages = $post->images ?? [];
        if ($request->has('remove_images')) {
            $currentImages = array_diff($currentImages, $request->remove_images);
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $up = $this->imageKit->upload([
                    'file' => fopen($file, 'r'),
                    'fileName' => 'ez_img_' . time(),
                    'folder' => '/easypoint/gallery/'
                ]);
                $currentImages[] = $up->result->url;
            }
        }
        $data['images'] = array_values($currentImages);

        $post->update($data);
        return redirect()->route('admin.easypoint.index')->with('success', 'บันทึกการแก้ไขเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $post = EasyPointPost::findOrFail($id);
        $post->delete();
        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
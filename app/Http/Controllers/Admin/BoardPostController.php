<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardPost;
use ImageKit\ImageKit;

class BoardPostController extends Controller
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

    // 1. หน้าแสดงรายการทั้งหมด
    public function index()
    {
        $posts = BoardPost::latest()->get();
        return view('admin.board.index', compact('posts'));
    }

    // 2. ฟอร์มสร้างใหม่
    public function create()
    {
        return view('admin.board.create');
    }

    // 3. บันทึกข้อมูล
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'content' => 'nullable',
        ]);

        // อัปโหลดปก
        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'board_cover_' . time(),
                'folder' => '/board/'
            ]);
            $data['cover_image'] = $upload->result->url;
        }

        // อัปโหลดแกลเลอรี
        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $up = $this->imageKit->upload([
                    'file' => fopen($file, 'r'),
                    'fileName' => 'board_img_' . time(),
                    'folder' => '/board/gallery/'
                ]);
                $gallery[] = $up->result->url;
            }
        }
        $data['images'] = $gallery;

        BoardPost::create($data);
        return redirect()->route('admin.board.index')->with('success', 'เพิ่มหัวข้อใหม่เรียบร้อยแล้ว');
    }

    // 4. ฟอร์มแก้ไข
    public function edit($id)
    {
        $post = BoardPost::findOrFail($id);
        return view('admin.board.edit', compact('post'));
    }

    // 5. อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $post = BoardPost::findOrFail($id);
        $data = $request->except(['cover_image', 'gallery_images', 'remove_images']);

        // แก้ไขปก
        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'board_cover_' . time(),
                'folder' => '/board/'
            ]);
            $data['cover_image'] = $upload->result->url;
        }

        // แก้ไขแกลเลอรี
        $currentImages = $post->images ?? [];
        if ($request->has('remove_images')) {
            $currentImages = array_diff($currentImages, $request->remove_images);
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $up = $this->imageKit->upload([
                    'file' => fopen($file, 'r'),
                    'fileName' => 'board_img_' . time(),
                    'folder' => '/board/gallery/'
                ]);
                $currentImages[] = $up->result->url;
            }
        }
        $data['images'] = array_values($currentImages);

        $post->update($data);
        return redirect()->route('admin.board.index')->with('success', 'บันทึกการแก้ไขเรียบร้อยแล้ว');
    }

    // 6. ลบข้อมูล
    public function destroy($id)
    {
        $post = BoardPost::findOrFail($id);
        // (ควรเพิ่มโค้ดลบรูปใน ImageKit ด้วยถ้าต้องการ)
        $post->delete();
        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
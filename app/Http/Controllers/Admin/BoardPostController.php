<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardPost;
use ImageKit\ImageKit;
use Inertia\Inertia; // <--- เรียกใช้ Inertia

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

    public function index()
    {
        $posts = BoardPost::latest()->get();
        // เปลี่ยนเป็น Inertia
        return Inertia::render('Admin/Board/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Board/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'content' => 'nullable',
        ]);

        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'board_cover_' . time(),
                'folder' => '/board/'
            ]);
            $data['cover_image'] = $upload->result->url;
        }

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

    public function edit($id)
    {
        $post = BoardPost::findOrFail($id);
        return Inertia::render('Admin/Board/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = BoardPost::findOrFail($id);
        $data = $request->except(['cover_image', 'gallery_images', 'remove_images']);

        if ($request->hasFile('cover_image')) {
            $upload = $this->imageKit->upload([
                'file' => fopen($request->file('cover_image'), 'r'),
                'fileName' => 'board_cover_' . time(),
                'folder' => '/board/'
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

    public function destroy($id)
    {
        $post = BoardPost::findOrFail($id);
        $post->delete();
        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
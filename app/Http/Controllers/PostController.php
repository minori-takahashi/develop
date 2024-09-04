<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('welcome', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        Post::create([
            'content' => $request->input('content'),
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', '保存が成功しました！');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('index', compact('posts'));
    }
    
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }
}

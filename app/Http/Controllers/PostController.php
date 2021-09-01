<?php

namespace App\Http\Controllers;



use App\Http\Services\PostService;
use App\Models\Post;

class PostController extends Controller
{
    public $postService;

    public function __construct(PostService $service)
    {
        $this->postService = $service;
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

}

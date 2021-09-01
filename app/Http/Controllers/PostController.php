<?php

namespace App\Http\Controllers;

use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPost()
    {
        $posts = $this->postRepository->getPost();
        return response()->json($posts);
    }

    public function createPost(Request $request)
    {
        $newPost = $this->postRepository->newPost($request->all());

        return response()->json([
            "data" => [
                "message" => "create post success",
                "data" => $newPost,
            ]
        ]);
    }



    public function deletePost($id)
    {
        $post = $this->postRepository->delete($id);
        return response()->json($post);
    }



}

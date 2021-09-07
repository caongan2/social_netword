<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\PostService;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostServiceImpl implements PostService
{
    public $postRepository;
    public $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }

    public function destroy($id)
    {
        return Post::destroy($id);

    }

    public function update($request,$id)
    {
        $post = Post::find($id);
       return $this->postRepository->update($request,$post);
    }

    public function create($request)
    {
        return $this->postRepository->create($request);
    }

    public function getPostByUser($id)
    {
        $user = $this->userRepository->findById($id);
        $post = Post::where('userId',$user->id)->get();
        return $post;
    }
}

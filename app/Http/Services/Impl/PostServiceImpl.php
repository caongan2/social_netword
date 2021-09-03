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
        $post = $this->postRepository->findById($id);
        $user = $post['user_id'];
        if ( Auth::id() == $user){
            return $this->postRepository->destroy($post);
        }else{
            $message = "Không được phép xóa bài viết";
            return $message;
        }

    }

    public function update($request,$id)
    {

        $post = $this->postRepository->findById($id);
       return $this->postRepository->update($request,$post);
    }

    public function create($request)
    {
        $post = $this->postRepository->create($request);
        return $post;
    }

    public function findById($id)
    {
        $post = $this->postRepository->findById($id);
        $user = $post['user_id'];
        if ( Auth::id() == $user){
            return $post;
        }else{
            $message = "Không được phép chỉnh sửa bài viết";
            return $message;
        }

    }
}

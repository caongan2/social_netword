<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\PostRepository;
use App\Http\Services\PostService;
use App\Models\Post;
use App\Models\User;

class PostServiceImpl implements PostService
{
    public $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }

    public function findById($id)
    {
        $post = $this->postRepository->findById($id);
        return $this->postRepository->destroy($post);
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
}

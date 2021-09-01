<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\PostRepository;
use App\Http\Services\PostService;

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
        // TODO: Implement findById() method.
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.

    }

    public function create($request)
    {
        // TODO: Implement create() method.
    }
}

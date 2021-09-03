<?php


namespace App\Http\Repositories\Impl;


use App\Http\Repositories\Eloquent\EloquentRepository;
use App\Http\Repositories\PostRepository;
use App\Models\Post;

class PostRepositoryImpl extends EloquentRepository implements PostRepository
{
    public function getModel()
    {
        $model = Post::class;
        return $model;
    }

}

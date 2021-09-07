<?php


namespace App\Http\Repositories\Impl;


use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\Eloquent\EloquentRepository;
use App\Models\Comment;

class CommentRepositoryImpl extends EloquentRepository implements CommentRepository
{

    public function getModel()
    {
        $model = Comment::class;
        return $model;
    }
}

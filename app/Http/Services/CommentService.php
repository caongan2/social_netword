<?php


namespace App\Http\Services;


interface CommentService
{
    public function findById($id);
    public function getCommentByPost($id);
    public function update($request, $id);
    public function create($request);
    public function destroyComment($id);
}

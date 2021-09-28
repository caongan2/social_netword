<?php


namespace App\Http\Services;


interface PostService
{
    public function getAll();
    public function getPostByUser($id);
    public function update($request, $id);
    public function create($request);
    public function destroy($id);
    public function findById($id);
}

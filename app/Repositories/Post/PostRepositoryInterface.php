<?php


namespace App\Repositories\Post;


Interface PostRepositoryInterface
{
    public function newPost(array $data);

    public function getPost();

    public function delete($id);

    public function update($id, array $data);
}

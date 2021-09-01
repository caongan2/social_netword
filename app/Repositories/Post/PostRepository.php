<?php


namespace App\Repositories\Post;
use App\Models\Post;
use App\Models\User;

class PostRepository implements PostRepositoryInterface
{
    public function newPost(array $data)
    {

        $newData = [
            'user_id' => 1,
            'content' => $data['content'],
            'is_public' => true
        ];
        $post = new Post();
        $post->fill($newData);
        $post->save();
        return $post;
    }

    public function getPost()
    {
        return Post::orderBy('id', 'desc')->get();
    }

    public function delete($id)
    {
        Post::destroy($id);
    }

    public function update($id, array $data)
    {
        Post::find($id)->update($data);
    }
}

<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\PostService;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.userId')
            ->select('users.name','users.image', 'posts.content', 'posts.userId','posts.id','posts.is_public','posts.created_at', 'posts.image')
            ->where('is_public',true)
            ->limit(10)
            ->orderByDesc('posts.id')
            ->get();
        return $posts;
    }

    public function destroy($id)
    {
        $post = $this->postRepository->findById($id);
        $post->delete();
        return response()->json(['message' => 'Success']);
//        return $this->postRepository->destroy($id);

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
        $post = DB::table('posts')->join('users','users.id','=','posts.userId')
            ->select('users.name','posts.content','posts.id', 'posts.image')
            ->where('userId',$id)
            ->orderByDesc('posts.id')
            ->get();
//        $post = Post::where('userId',$user->id)->get();
        return $post;
    }

    public function findById($id)
    {
        return $this->postRepository->findById($id);
    }
}

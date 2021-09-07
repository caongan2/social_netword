<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\CommentService;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentServiceImpl implements CommentService
{

    public $postRepository;
    public $userRepository;
    public $commentRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository, CommentRepository $commentRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
    }

    public function create($request)
    {
        return $this->commentRepository->create($request);
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function getCommentByPost($id)
    {
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('users.name', 'comments.content', 'comments.id')
            ->where('post_id', $id)
            ->get();
        return $comments;
    }

    public function destroyComment($id)
    {
        return Comment::destroy($id);
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

}

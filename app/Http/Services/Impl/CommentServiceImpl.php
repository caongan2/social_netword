<?php


namespace App\Http\Services\Impl;


use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\CommentService;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $comment = $this->commentRepository->findById($id);
        return $comment;
    }

    public function getCommentByPost($id)
    {
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('users.name','users.image', 'comments.content', 'comments.id', 'comments.created_at')
            ->where('post_id', $id)
            ->orderByDesc('id')
            ->get();
        return $comments;
    }

    public function destroyComment($id)
    {
        $comment = $this->commentRepository->findById($id);
        return $this->commentRepository->destroy($comment);
    }

    public function update($request, $id)
    {
        $comment = $this->commentRepository->findById($id);
        return $this->commentRepository->update($request, $comment);
    }

    public function likeComment($id)
    {
        $likeComment = Like::where('comment_id', $id)->where('user_id', Auth::id())->first();
        if ($likeComment) {
            $likeComment->delete();
        } else {
            $like = new Like();
            $like->user_id = Auth::id();
            $like->comment_id = $id;
            $like->is_status = true;
            $like->save();
        }
        $countLike = Like::where('comment_id',$id)->count();
        return response()->json($countLike);
    }

}

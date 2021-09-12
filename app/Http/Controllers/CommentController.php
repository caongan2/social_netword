<?php

namespace App\Http\Controllers;

use App\Http\Services\CommentService;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $comments = $this->commentService->getCommentByPost($id);
        return response()->json($comments);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(Request $request)
    {

        $comment = $this->commentService->create($request->all());
        $data = [
            "message" => "comment success",
            "data" => $comment,
        ];

//        dd($request->all());
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComment($id)
    {
        return $this->commentService->findById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = $this->commentService->update($request->all(), $id);
        $data = [
            'message' => 'Update comment successfully',
            'data' => $comment
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->commentService->destroyComment($id);
        return response()->json(['message' => 'delete success']);
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

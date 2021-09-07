<?php

namespace App\Http\Controllers;



use App\Http\Services\PostService;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{


    /**
     * @var PostService
     */
    public $postService;

    public function __construct(PostService $service)
    {
        $this->postService = $service;
    }

    public function index()
    {
        $posts = DB::table('posts')

            ->join('users', 'users.id', '=', 'posts.userId')
            ->select('users.name', 'posts.content', 'posts.id', 'posts.is_public', 'posts.created_at')
            ->orderByDesc('posts.id')
            ->get();
        return response()->json($posts);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required',
            'content' => 'required',
            'images' => 'mimes:jpg,bmp,png',
            'is_public' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $post = $this->postService->create($request->all());
        $data = [
            "message" => "create post success",
            "data" => $post,
        ];
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'is_public' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $post = $this->postService->update($request->all(), $id);
        $data = [
            "message" => "update post success",
            "data" => $post,
        ];
        return response()->json($data);
    }

    public function delete($id)
    {
        $post = $this->postService->destroy($id);
        return response()->json($post);
    }

    public function getPostByUser($id)
    {
        $post = $this->postService->getPostByUser($id);
        return response()->json($post);
    }

    public function showPost($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    public function likePost($id)
    {
        $likePost = new Like();
        $likePost->user_id = Auth::id();
        $likePost->post_id = $id;
        $likePost->save();
        return response()->json($likePost);
    }

    function disLike($id)
    {
        $likePost = Like::Where([['post_id', $id], ['user_id', Auth::id()]]);
        $likePost->delete();
        return response()->json(['Delete successfully']);
    }

    public function countLikeByPost($id)
    {
        $like = Like::where('post_id', $id)->get();
        return response()->json($like);
    }
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        /* Store $imageName name in DATABASE from HERE */

        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('image', $imageName);
    }
}

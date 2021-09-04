<?php

namespace App\Http\Controllers;



use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Http\Request;
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
            ->select('users.name', 'posts.content', 'posts.id', 'posts.is_public','posts.created_at')
            ->orderByDesc('posts.id')
            ->get();
        return response()->json($posts);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'userId'=>'required',
            'content'=>'required',
            'is_public'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $post = $this->postService->create($request->all());
        $data = [
            "message" => "create post success",
            "data" => $post,
        ];
        return response()->json($data);

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required',
            'is_public'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $post = $this->postService->update($request->all(),$id);
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

}

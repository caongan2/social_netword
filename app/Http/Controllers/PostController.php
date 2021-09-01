<?php

namespace App\Http\Controllers;


use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Http\Request;
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
       return $this->postService->getAll();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id'=>'required',
            'content'=>'required',
            'is_public'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
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
            return response()->json($validator->errors());
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
        $post = $this->postService->findById($id);
        return response()->json($post);
    }
}

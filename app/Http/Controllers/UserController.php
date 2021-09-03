<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function getAll()
    {
        $users = $this->userService->getAll();
        return $users;
    }

    public function store(Request $request)
    {
        $dataUser = $this->userService->create($request->all());
        return response()->json($dataUser['users'], $dataUser['statusCode']);
    }

    public function update(UserRequest $request, $id)
    {
//        return $this->userService->update($request->all(), $id);
        $user = $this->userService->update($request->all(),$id);
        $messages = $request->messages();
        $data = [
            "message" => "update user success",
            "data" => $user,
        ];
        return response()->json($data);
    }

    public function detail($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
}

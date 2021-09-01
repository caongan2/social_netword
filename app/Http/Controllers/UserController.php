<?php

namespace App\Http\Controllers;

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

    public function update(Request $request, $id)
    {
        return $this->userService->update($request->all(), $id);
    }
}

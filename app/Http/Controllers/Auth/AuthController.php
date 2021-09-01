<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [ 'register']]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:6|max:8',
            'phone' => 'required|regex:/^(0+[0-9]{9})$/|unique:users',
        ]);

        if ($validator->fails()) {
//            return response()->json($validator->errors(), 400);
            return response()->json([
                $validator->errors()->toJson(),
                'message' => 'Email đã tồn tại!',
                'error' => 'email'
            ], 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
            ]
        ));

        return response()->json([
            'message' => 'Bạn đã đăng ký thành công!',
            'user' => $user
        ], 201);
    }

}

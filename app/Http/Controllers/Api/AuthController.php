<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','loginGoogle']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {

            $user = User::where('email', $request->email)->first();
            $msg = "";
            if ($user) {
                $msg = "Sai mat khau";
            } else {
                $msg = "Tai khoan ko ton tai";
            }
            return response()->json([
                'message' => $msg,
                'error' => 'Unauthorized'
            ]);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:5,100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:6|max:20',
            'phone' => 'regex:/^(0+[0-9]{9})$/|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 422);
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


    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successfully']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6|max:20',
            'new_password' => 'required|confirmed|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = auth()->user()->id;

        $user = User::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'message' => 'Change password success',
            'user' => $user
        ], 201);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function loginGoogle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'access_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }
        $userSocial = Socialite::driver('google')->userFromToken($request->access_token);
        $user = $this->createUserGoogle($userSocial,'google');
        $token = auth('api')->tokenById($user->id);
        $data = [
            'user' => $user,
            'access_token' => $token
        ];
        return response()->json($data);
    }

    public function createUserGoogle($userGoogle, $provider)
    {
        $user = User::where('provider_id', $userGoogle->id)->first();
        if (!$user) {
            $user = User::create([
                'name' => $userGoogle->name,
                'email' => $userGoogle->email,
                'provider' => $provider,
                'provider_id' => $userGoogle->id
            ]);
        }
        return $user;
    }
}

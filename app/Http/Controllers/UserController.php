<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\AuthController;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $userService;
    protected $authControler;

    public function __construct(UserService $service,
                                AuthController $authController)
    {
        $this->userService = $service;
        $this->authControler = $authController;
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
//        $user = $this->userService->update($request->all(),$id);
//        $data = [
//            "message" => "update user success",
//            "data" => $user,
//        ];
//        return response()->json($data);
        $dataUser = $this->userService->update($request->all(),$id);
        return response()->json($dataUser['users'],$dataUser['statusCode']);
    }

    public function findUser(Request $request)
    {
        $text = $request->name;
        $user = User::where('name','like','%'.$text.'%')->get();
        return response()->json([$user]);
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleByGoogleCallback()
    {
        $getInfor = Socialite::driver('google')->stateless()->user();
        $user = $this->createUser($getInfor, 'google');
        auth()->login($user);
        $token = JWTAuth::fromUser($user);
        if (!$token) {
            return response()->json(['message' => 'unauthorize']);
        }
        dd($token);
    }

    public function createUser($getInfor, $provider)
    {
        $user = User::where('email',$getInfor->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $getInfor->name,
                'email' => $getInfor->email,
                'provider' => $provider,
                'provider_id' => $getInfor->id,
                'password' => Hash::make('123456')
            ]);
        }

        return $user;
    }

}

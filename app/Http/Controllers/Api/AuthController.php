<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {

    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }
}

<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\Client\RegisterRequest;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        return $request->registerClient();
    }

    public function login(LoginRequest $request)
    {
        return $request->loginClient();
    }

    public function profile(Request $request)
    {
        auth()->user()->update($request->all());
        return auth()->user()->load('region.city')->makeHidden('password');
    }

}

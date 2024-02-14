<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequests,ResetPasswordRequests,ForgotPasswordRequests,VerifyPinRequests};
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;


class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    
    public function login(LoginRequests $request) {
        $result = $this->service->login($request->validated());
        return response()->json([
            "message" => $result["message"],
            "token" => isset($result["token"]) ? $result["token"] : "",
            "role" => isset($result["role"]) ? $result["role"] : "",
            "expiredIn" => isset($result["expiresIn"]) ? $result["expiresIn"] : "",
            "code" => $result["code"],
        ], $result["code"]);
    }

    public function logout() {
        $result = $this->service->logout();
        return response()->json([
            "message" => $result["message"],
            "code" => $result["code"],
        ], $result["code"]);
    }
}

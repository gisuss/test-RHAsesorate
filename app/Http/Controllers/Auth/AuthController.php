<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequests,ResetPasswordRequests,ForgotPasswordRequests,VerifyPinRequests};
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }
    
    public function login(Request $request) {
        $result = $this->service->login($request);
        return response()->json($result);
    }

    public function logout() {
        $result = $this->service->logout();
        return response()->json($result);
    }
}

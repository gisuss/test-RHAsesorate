<?php

namespace App\Services\Auth;

use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{Auth, DB, Hash, Mail};
use App\Mail\{ForgotPasswordMail, ResetPasswordMail};
use App\Models\{User};
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthService
{
    private User $userModel;

    public function __construct(User $user) {
        $this->userModel = $user;
    }

    /**
     * login method.
     * 
     * @param array $data
     * @return array
     */
    public function login(array $data) : array {
        $array = [];
        $fieldType = filter_var($data['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt(array($fieldType => $data['email_username'], 'password' => $data['password']))) {
            if ($fieldType == 'username') {
                $user = User::where('username', $data['email_username'])->first();
            }else{
                $user = User::where('email', $data['email_username'])->first();
            }

            if ($user === null) {
                $array['message'] = "Las credenciales suministradas son inválidas.";
                $array['code'] = Response::HTTP_UNAUTHORIZED;
            }else{
                if ($user->active) {
                    if (config('app.env') === 'production') {
                        $user->tokens()->delete();
                    }
                    $permisos = $user->getAllPermissions();
                    $tokenAbilities = [];
                    foreach ($permisos as $permiso) {
                        $tokenAbilities[] = $permiso->name;
                    }
                    $token = $user->createToken("login-".$data['email_username'], $tokenAbilities);
        
                    $array['message'] = "Usuario logeado exitosamente.";
                    $array['code'] = Response::HTTP_OK;
                    $array['token'] = $token->plainTextToken;
                    $array['role'] = $user->getRoleNames()[0];
        
                    $now = Carbon::now();
                    $expires_at = Carbon::parse($token->accessToken->expires_at);
                    $expires_in = $expires_at->diffInRealHours($now);
                    $array['expiresIn'] = $expires_in . " horas";
                }else{
                    $array['message'] = "No tienes permitido el acceso, consulte con su superior.";
                    $array['code'] = Response::HTTP_FORBIDDEN;
                }
            }
        }else{
            $array['message'] = "Las credenciales suministradas son inválidas.";
            $array['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $array;
    }

    public function logout() {
        $id = auth()->id();
        $array = [];
        if (isset($id)) {
            $user = $this->userModel->find($id);
            $user->tokens()->delete();
            $user->remember_token = NULL;
            $user->update();

            $array['message'] = "Cierre de Sesión Exitoso.";
            $array['code'] = Response::HTTP_OK;
        }else{
            $array['message'] = "Cierre de Sesión Fallido.";
            $array['code'] = Response::HTTP_NOT_FOUND;
        }
        return $array;
    }
}

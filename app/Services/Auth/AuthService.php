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
     * @param Request $data
     * @return array
     */
    public function login(Request $data) : array {
        $array = [];
        $fieldType = filter_var($data['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt(array($fieldType => $data['email_username'], 'password' => $data['password']))) {
            if ($fieldType == 'username') {
                $user = User::where('username', $data['email_username'])->first();
            }else{
                $user = User::where('email', $data['email_username'])->first();
            }

            if ($user === null) {
                $array = [
                    'success' => false,
                    'message' => 'The credentials supplied are invalid.',
                    'code' => Response::HTTP_UNAUTHORIZED
                ];
            }else{
                if ($user->active) {
                    $user->tokens()->delete();

                    $token = $user->createToken("login-".$data['email_username']);
        
                    $now = Carbon::now();
                    $expires_at = Carbon::parse($token->accessToken->expires_at);
                    $expires_in = $expires_at->diffInRealHours($now);

                    $array = [
                        'success' => true,
                        'token' => $token->plainTextToken,
                        'role' => $user->getRoleNames()[0],
                        'user_id' => $user->id,
                        'message' => 'User successfully logged in.',
                        'expiresIn' => $expires_in . " horas",
                        'code' => Response::HTTP_OK
                    ];
                }else{
                    $array = [
                        'success' => false,
                        'message' => 'You are not allowed access, check with your superior.',
                        'code' => Response::HTTP_FORBIDDEN
                    ];
                }
            }
        }else{
            $array = [
                'success' => false,
                'message' => 'The credentials supplied are invalid.',
                'code' => Response::HTTP_BAD_REQUEST
            ];
        }

        return $array;
    }

    public function logout() {
        $array = [];
        $id = Auth::user()->id;

        if (isset($id)) {
            $user = $this->userModel->find($id);
            $user->tokens()->delete();
            $user->remember_token = null;
            $user->update();

            $array = [
                'success' => true,
                'message' => 'Successful Logout.',
                'code' => Response::HTTP_OK
            ];
        }else{
            $array = [
                'success' => false,
                'message' => 'Failed Logout.',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }

        return $array;
    }
}

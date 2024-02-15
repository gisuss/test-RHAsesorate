<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\{Identification, User};
use Illuminate\Http\Response;
use App\Repositories\Users\UserRepository;
use App\Helpers\StandardResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\{DB, Hash};

class UserUpdateResponsable implements Responsable
{
    use StandardResponse;
    private UserRepository $repository;
    private array $data;
    protected int $user;

    public function __construct(int $user, array $data, UserRepository $repository = null) {
        $this->repository = $repository ?? new UserRepository(new User());
        $this->data = $data;
        $this->setUser($user);
    }

    public function toResponse($request) {
        try {
            DB::beginTransaction();
                $usuario = $this->repository->find($this->user);

                if (isset($this->data['role'])) {
					$usuario->syncRoles([$this->data['role']]);
                }

                if (isset($this->data['password'])) {
                    $update = $usuario->update([
                        'name' => $this->data['name'],
                        'lastname' => $this->data['lastname'],
                        'email' => $this->data['email'],
                        'password' => Hash::make($this->data['password'])
                    ]);
                }else{
                    $update = $usuario->update([
                        'name' => $this->data['name'],
                        'lastname' => $this->data['lastname'],
                        'email' => $this->data['email'],
                    ]); 
                }
            DB::commit();
            return $this->updateResponse(UserResource::make($usuario), $update ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'code' =>  Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Cannot update user.',
                'data' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setUser($user) {
        $this->user = $user;
    }
}
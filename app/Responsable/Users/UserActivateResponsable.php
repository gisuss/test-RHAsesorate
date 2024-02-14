<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\Users\UserRepository;
use App\Helpers\StandardResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;

class UserActivateResponsable implements Responsable
{
    use StandardResponse;
    private UserRepository $repository;
    private int $user;
    private array $request;

    public function __construct(int $user, array $data, UserRepository $repository = null) {
        $this->repository = ($repository === null) ? new UserRepository(new User()) : $repository;
        $this->user = $user;
        $this->request = $data;
    }

    public function toResponse($request) {
        try {
            DB::beginTransaction();
                $activado = $this->repository->activar($this->user, $this->request);
            DB::commit();
            return $this->updateResponse(UserResource::make($this->repository->find($this->user)), $activado ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'menssage' => 'No se puede activar al usuario.',
                'code' => Response::HTTP_BAD_REQUEST,
                'data' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{UserUpdateRequest};
use App\Responsable\Users\{ UserShowResponsable,UserDestroyResponsable, UserIndexResponsable,UserGetByRoleResponsable,
                            UserStoreResponsable, UserUpdateResponsable, UserDesactivateResponsable,UserActivateResponsable,
                            UserShowFavQuotes
                          };

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param mixed $userIndexResponsable
     * @return void
     */
    public function index(UserIndexResponsable $userIndexResponsable)
    {
        return $userIndexResponsable;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param mixed $userStoreResponsable
     * @return void
     */
    public function store(UserStoreResponsable $userStoreResponsable)
    {
        return $userStoreResponsable;
    }

    /**
     * Display the specified resource.
     * 
     * @param int $user
     * @return void
     */
    public function show(int $user)
    {
        return new UserShowResponsable($user);
    }

    /**
     * Display users by role name.
     * 
     * @param int $user
     * @return void
     */
    public function getUsersByRole(UserGetByRoleResponsable $userGetByRoleResponsable)
    {
        return $userGetByRoleResponsable;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param int $user
     * @param UserUpdateRequest $request
     * @return void
     */
    public function update(int $user, UserUpdateRequest $request)
    {
        return new UserUpdateResponsable($user, $request->validated());
    }

    /**
     * Desactive an specified user.
     * 
     * @param int $user
     * @return void
     */
    public function desactivarUser(int $user) {
        return new UserDesactivateResponsable($user);
    }
    
    /**
     * Desactive an specified user.
     * 
     * @param int $user
     * @return void
     */
    public function activarUser(int $user) {
        return new UserActivateResponsable($user);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param mixed $user
     * @return void
     */
    public function destroy(int $user)
    {
        return new UserDestroyResponsable($user);
    }
}

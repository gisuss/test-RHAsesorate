<?php

namespace App\Http\Resources;

use App\Models\Quote;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $roleName = 'No role';
        $role = DB::table('model_has_roles')->select('*')->where('model_id', $this->id)->first();
        if ($role) {
            $rol = Role::where('id', $role->role_id)->first();
            if ($rol) {
                $roleName = $rol->name;
            }
        }

        $quotes = Quote::filteruser($this->id)->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'fullname' => $this->name . ' ' . $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $roleName,
            'quotes' => isset($quotes) ? $quotes : 0,
        ];
    }
}

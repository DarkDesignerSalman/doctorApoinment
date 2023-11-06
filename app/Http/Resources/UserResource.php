<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'success'=>true,
           
             'user_id' => $this->id,
             'name' => $this->name,
             'username' => $this->username,
             'email' => $this->email,
             'token' => $this->createToken("Token")->plainTextToken,
             'roles' => $this->roles->pluck('name') ?? [],
             'permissions'=> $this->getPermissionsViaRoles()->pluck('name')??[],
        ];
    }
}

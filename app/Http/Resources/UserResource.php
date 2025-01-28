<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
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
            // "token" => $this->token,
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "email_verified_at"=> $this->email_verified_at == null ? "NotVerified" : $this->email_verified_at,
            "role_id"=> $this->role_id,
            "role" => new RoleResource( $this->role),
            "created_at"=> $this->created_at->translatedFormat('l, Y-F-d H:i:s'),
            "updated_at"=> $this->updated_at->translatedFormat('l, Y-F-d H:i:s'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "price"=> $this->price,
            "image"=> $this->image,
            "category"=> new CategoryResource( $this->category),
            "created_at"=> $this->created_at->translatedFormat('l, Y-m-d H:i:s'),
            "updated_at"=> $this->updated_at->translatedFormat('l, Y-m-d H:i:s'),
            "deleted_at"=> isset($this->deleted_at) ? $this->deleted_at->translatedFormat('l, Y-m-d H:i:s') : null,
        ];
    }
}
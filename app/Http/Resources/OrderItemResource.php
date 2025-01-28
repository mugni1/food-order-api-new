<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderItemDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "item" => new OrderItemDetailResource($this->item),
            "price" => $this->price,
            "qty" => $this->qty,
        ];
    }
}
<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderUserResource;
use App\Http\Resources\UserOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            "customer_name"=> $this->customer_name,
            "table_no"=> $this->table_no,
            "status"=> $this->status,
            "total"=> $this->total,
            "order_date"=> $this->order_date,
            "order_time"=> $this->order_time,
            "waiter" => new OrderUserResource($this->waiter),
            "cashier" => new OrderUserResource($this->cashier),
            "order_details" => OrderItemResource::collection($this->orderDetails),
        ];
    }
}

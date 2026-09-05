<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'order_number' => $this->order_number,

            'status' => $this->status?->value,

            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shipping,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'tax_percentage' => $this->tax > 0 && $this->subtotal > 0
                ? round(($this->tax / max(0.01, $this->subtotal - $this->discount)) * 100, 2)
                : 0,
            'total' => $this->total,

            'user' => UserResource::make(
                $this->whenLoaded('user')
            ),

            'items' => OrderItemResource::collection(
                $this->whenLoaded('items')
            ),

            'payment' => PaymentResource::make(
                $this->whenLoaded('payment')
            ),

            'shipping' => [
                'name' => $this->shipping_name,
                'phone' => $this->shipping_phone,
                'country' => $this->shipping_country,
                'state' => $this->shipping_state,
                'city' => $this->shipping_city,
                'address' => $this->shipping_address,
                'postal_code' => $this->shipping_postal_code,
            ],

            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order_id'=>$this->order_id,
            'customer_id'=>$this->customer_id, 
            'creation_date'=>$this->creation_date, 
            "delivery_address"=>$this->delivery_address,
            'total'=>$this->total,
            'orders_details'=> OrderDetailsResource::collection($this->whenLoaded('OrderDetail'))
        ];
    }
}

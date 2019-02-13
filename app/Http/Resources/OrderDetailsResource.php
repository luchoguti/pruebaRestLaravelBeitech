<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            'order_detail_id'=>$this->order_detail_id,
            'order_id'=>$this->order_id,
            'product_description'=>$this->product_description,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'products'=> new ProductsResource($this->Products)
        ];
    }
}

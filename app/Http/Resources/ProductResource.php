<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'type' => 'products',
            'id' => (string) $this->getRouteKey(),
            'attributes'=>[
                'product_name' => $this->product_name,
                'list_price' => $this->list_price,
                'url_product_img' => $this->url_product_img,
            ],
            'relationships' => New ProductCategoryResource($this->category),
            'links' => [
                'self' => route('api.v1.products.index' ,$this)
            ]
        ];
    }
}

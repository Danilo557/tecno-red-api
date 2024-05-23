<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'brand_id' => $this->brand_id,
             
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            "pivot"=>$this->whenLoaded("pivot")
        ];
    }
}

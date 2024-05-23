<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "id"=>$this->id,
            "folio"=>$this->folio,
            "date"=>$this->date,
            "store_id"=>$this->store_id,
            "store"=>StoreResource::make($this->whenLoaded("store")),
            "status"=>$this->status,
            "products"=>ProductResource::collection($this->whenLoaded("products")),
            "charges"=>ChargeResource::collection( $this->whenLoaded("charges")),
            "files"=> FileResource::collection( $this->whenLoaded("files"))
        ];
    }
}

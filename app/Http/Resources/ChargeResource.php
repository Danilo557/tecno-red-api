<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChargeResource extends JsonResource
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
            "id" => $this->id,
            "chargeable_id"=>$this->chargeable_id,
            "chargeable_type"=>$this->chargeable_type,
            "description"=>$this->description,
            "amount"=>$this->amount,
            "type"=>$this->type,
            "date"=>$this->date,
            "status"=>$this->status,
            "payments"=>PaymentResource::collection( $this->whenLoaded("payments")),
        ];
    }
}

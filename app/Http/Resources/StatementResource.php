<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementResource extends JsonResource
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
            'client_id' => $this->client_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'days' => $this->days,
            'type' => $this->type,
            'status'=>$this->status,
            'client'=>ClientResource::make($this->whenLoaded('client')),
            'payments'=>PaymentResource::collection($this->whenLoaded("payments")),
            'charges'=> ChargeResource::collection( $this->whenLoaded("charges")),
        ];
    }
}

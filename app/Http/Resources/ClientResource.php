<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'pay_day' => $this->pay_day,
            'amount' => $this->amount,
            'status' => $this->status,
            'statements' => StatementResource::collection($this->whenLoaded('statements'))
            
        ];
    }
}

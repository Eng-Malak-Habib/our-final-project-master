<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class paymentsResource extends JsonResource
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
            'Amount' => $this->Amount,
            'Note' => $this->Note,
            'Case_id' => $this->Case_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

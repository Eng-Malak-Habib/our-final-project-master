<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class investigationsResource extends JsonResource
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
            'investigation_id' => $this->investigation_id,
            'topic' => $this->topic,
            'in_Date' => $this->in_Date,
            'client' => $this->client,
            'contender' => $this->contender,
            'Decision' => $this->Decision,
            'Lawyer_id' => $this->Lawyer_id,
            'Case_id' => $this->Case_id,
            'Note' => $this->Note,
            'investigation_place_No' => $this->investigation_place_No,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

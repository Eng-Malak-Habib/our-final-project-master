<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class legislationsResource extends JsonResource
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
            'Attachment' => $this->Attachment,
            'Lawyer_id' => $this->Lawyer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
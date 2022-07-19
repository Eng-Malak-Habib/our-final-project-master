<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class case_attachmentsResource extends JsonResource
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
            'Case_id' => $this->Case_id,
            'Attachment' => $this->Attachment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

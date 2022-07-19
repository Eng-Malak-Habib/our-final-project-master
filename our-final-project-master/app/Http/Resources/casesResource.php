<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class casesResource extends JsonResource
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
            'Title' => $this->Title,
            'Case_type' => $this->Case_type,
            'client_name' => $this->client_name,
            'contender' => $this->contender,
            'Court_no' => $this->Court_no,
            'Content' => $this->Content,
            'Note' => $this->Note,
            'Attachment' => $this->Attachment,
            'status' => $this->status,
            'Lawyer_id' => $this->Lawyer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

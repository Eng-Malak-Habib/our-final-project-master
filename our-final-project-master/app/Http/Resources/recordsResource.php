<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class recordsResource extends JsonResource
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
            'record_id' => $this->record_id,
            'topic' => $this->topic,
            'Attachment' => $this->Attachment,
            'Note' => $this->Note,
            'Client_name' => $this->Client_name,
            'Contender' => $this->Contender,
            'Lawyer_id' => $this->Lawyer_id,
            'Case' => $this->Case,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

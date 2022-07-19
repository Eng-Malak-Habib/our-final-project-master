<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class expert_sessionsResource extends JsonResource
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
            'present_Lawyer_name' => $this->present_Lawyer_name,
            'Expert_name' => $this->Expert_name,
            'Session_Reason' => $this->Session_Reason,
            'Session_date' => $this->Session_date,
            'Office_address' => $this->Office_address,
            'Attachment' => $this->Attachment,
            'Desicion' => $this->Desicion,
            'Next_date' => $this->Next_date,
            'Case_id' => $this->Case_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

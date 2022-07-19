<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class sessionsResource extends JsonResource
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
            'Role_no' => $this->Role_no,
            'present_Lawyer_name' => $this->present_Lawyer_name,
            'Session_Reason' => $this->Session_Reason,
            'Session_date' => $this->Session_date,
            'Session_Requirements' => $this->Session_Requirements,
            'Attachment' => $this->Attachment,
            'Desicion' => $this->Desicion,
            'Next_date' => $this->Next_date,
            'Case_id' => $this->Case_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

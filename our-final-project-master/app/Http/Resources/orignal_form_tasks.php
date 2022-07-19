<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class orignal_form_tasks extends JsonResource
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
            'Title' => $this->Title,
            'Date' => $this->Date,
            'StartTime' => $this->StartTime,
            'EndTime' => $this->EndTime,
            'Description' => $this->Description,
            'Lawyer_id' => $this->Lawyer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}

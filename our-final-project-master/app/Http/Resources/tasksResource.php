<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class tasksResource extends JsonResource
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
            'Date' => Carbon::parse($this->Date)->format('Y/m/d'),
            'StartTime' => Carbon::parse($this->StartTime)->format('h:i A'),
            'EndTime' => isset($this->EndTime) ? Carbon::parse($this->EndTime)->format('h:i A') : null,
            'Description' => $this->Description,
            'Lawyer_id' => $this->Lawyer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class lawyerResource extends JsonResource
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
            'Lawyer_National_Number' => $this->Lawyer_National_Number,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'status' => $this->status,
            'address' => $this->address,
            'profile_photo_path' => $this->profile_photo_path,
            'Role' => $this->Role,
            'DOB' => $this->DOB,
            'Gender' => $this->Gender,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,


        ];
    }
}

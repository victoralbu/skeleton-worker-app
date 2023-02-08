<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'         => $this->name,
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'jobs_done'    => $this->jobs_done,
            'rating'       => $this->rating,
            'role'         => $this->role,
        ];
    }
}
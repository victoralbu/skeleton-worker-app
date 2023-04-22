<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'level'       => $this->level,
            'budget'      => $this->budget,
            'address'     => $this->address,
            'city'        => $this->city,
            'urgency'     => $this->urgency,
            'user'        => new UserResource($this->user),
            'winner'      => new UserResource($this->winner),
            'status'      => $this->status,
            'photos'      => PhotoResource::collection($this->photos),
        ];
    }
}

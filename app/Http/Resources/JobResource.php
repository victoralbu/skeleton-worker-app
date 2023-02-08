<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'title'       => $this->title,
            'description' => $this->description,
            'level'       => $this->level,
            'budget'      => $this->budget,
            'address'     => $this->address,
            'urgency'     => $this->urgency,
            'user'        => new UserResource($this->user),
            'group'       => new GroupResource($this->group),
            'winner'      => new UserResource($this->winner),
            'status'      => $this->status,
            'photos'      => new PhotoResource($this->photos),
        ];
    }
}

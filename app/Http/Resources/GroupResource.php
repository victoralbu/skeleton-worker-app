<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'admin'       => new UserResource($this->admin),
            'members_nr'  => $this->members_nr,
            'invite_code' => $this->invite_code,
            'jobs'        => JobResource::collection($this->jobs)
        ];
    }
}

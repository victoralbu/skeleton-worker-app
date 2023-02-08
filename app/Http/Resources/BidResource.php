<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job'       => new JobResource($this->job),
            'user'      => new UserResource($this->user),
            'date'      => $this->date,
            'few_words' => $this->few_words,
            'money'     => $this->money,
            'status'    => $this->status,
        ];
    }
}

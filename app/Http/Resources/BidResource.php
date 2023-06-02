<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BidResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'job'        => new JobResource($this->job),
            'user'       => new UserResource($this->user),
            'few_words'  => $this->few_words,
            'money'      => $this->money,
            'status'     => $this->status,
            'date'       => Carbon::createFromFormat('Y-m-d H:i:s', $this->date)->format('d/m/Y'),
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y'),
        ];
    }
}

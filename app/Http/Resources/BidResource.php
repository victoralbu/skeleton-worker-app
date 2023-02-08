<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
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
            'job'       => new JobResource($this->job),
            'user'      => new JobResource($this->user),
            'date'      => $this->date,
            'few_words' => $this->few_words,
            'money'     => $this->money,
            'status'    => $this->status,
        ];
    }
}

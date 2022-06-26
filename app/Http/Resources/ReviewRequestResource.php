<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewRequestResource extends JsonResource
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
            'id'         => $this->id,
            'created_by' => $this->createdBy->name,
            'reviewer'   => $this->reviewer->name,
            'reviewed'   => $this->reviewed->name,
            'done'       => $this->is_done,
            'created_at' => $this->created_at->format('Y.m.d H:i:s'),
        ];
    }
}
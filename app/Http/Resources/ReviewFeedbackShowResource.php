<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewFeedbackShowResource extends JsonResource
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
            'rating' => $this->rating,
            'id' => $this->id,
            'feedback' => $this->feedback,
            'reviewer' => $this->request->reviewer->name,
            'reviewed' => $this->request->reviewed->name,
            'created_at' => $this->created_at->format('Y.m.d H:i:s'),
        ];
    }
}
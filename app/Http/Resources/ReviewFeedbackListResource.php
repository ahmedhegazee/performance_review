<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewFeedbackListResource extends JsonResource
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
            'rating' => $this->rating,
            'feedback' => \substr($this->feedback, 0, 50),
            'reviewer' => $this->request->reviewer->name,
            'reviewed' => $this->request->reviewed->name,
            'created_at' => $this->created_at->format('Y.m.d H:i:s'),
        ];
    }
}
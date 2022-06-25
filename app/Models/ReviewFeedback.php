<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewFeedback extends Model
{
    use HasFactory;
    /**
     * fillable attributes
     *
     * @var array
     */
    protected $fillable = ['feedback', 'rating', 'review_request_id'];
    /**
     * request relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ReviewRequest::class, 'review_request_id');
    }
}
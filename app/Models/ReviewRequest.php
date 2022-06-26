<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReviewRequest extends Pivot
{
    use HasFactory;
    protected $fillable = ['reviewer_id', 'reviewed_id', 'is_done', 'created_by', 'id'];
    protected $table = 'review_requests';

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function feedback()
    {
        return $this->hasOne(ReviewFeedback::class, 'review_request_id');
    }
}
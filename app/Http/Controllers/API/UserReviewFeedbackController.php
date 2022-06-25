<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\{ReviewFeedbackListResource, ReviewFeedbackShowResource};
use App\Models\{ReviewFeedback};

class UserReviewFeedbackController extends Controller
{
    /**
     * Display a listing of review feedbacks
     *
     * @return App\Http\Resources\ReviewFeedbackListResource
     */
    public function index()
    {
        $reviewFeedbacks = auth()->user()->feedbacks()->with(['request.reviewer', 'request.reviewed'])->paginate(10);
        return ReviewFeedbackListResource::collection($reviewFeedbacks);
    }

    /**
     * Display review feedback.
     *
     * @param  ReviewFeedback  $review_feedback
     * @return App\Http\Resources\ReviewFeedbackShowResource
     */
    public function show(ReviewFeedback  $review_feedback)
    {
        $review_feedback->load(['request.reviewer', 'request.reviewed', 'request']);
        if ($review_feedback->request->reviewed_id != auth()->id())
            abort(401);
        return new ReviewFeedbackShowResource($review_feedback);
    }
}
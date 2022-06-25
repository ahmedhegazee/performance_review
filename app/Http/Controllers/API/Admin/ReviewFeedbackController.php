<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreReviewFeedbackRequest, UpdateReviewFeedbackRequest};
use App\Http\Resources\{ReviewFeedbackListResource, ReviewFeedbackShowResource};
use App\Models\{ReviewFeedback, ReviewRequest, User};
use Illuminate\Http\Request;

class ReviewFeedbackController extends Controller
{
    /**
     * Display a listing of review feedbacks
     *
     * @return App\Http\Resources\ReviewFeedbackListResource
     */
    public function index()
    {
        return ReviewFeedbackListResource::collection(ReviewFeedback::with(['request.reviewer', 'request.reviewed', 'request'])->paginate(10));
    }

    /**
     * Display review feedback.
     *
     * @param  ReviewFeedback  $review_feedback
     * @return App\Http\Resources\ReviewFeedbackShowResource
     */
    public function show(ReviewFeedback  $review_feedback)
    {
        return new ReviewFeedbackShowResource($review_feedback->load(['request.reviewer', 'request.reviewed', 'request']));
    }

    /**
     * create new feedback review.
     *
     * @param  App\Http\Requests\StoreReviewFeedbackRequest  $request
     * @return App\Http\Resources\ReviewFeedbackShowResource
     */
    public function store(StoreReviewFeedbackRequest $request)
    {
        $reviewedID = User::select('id')->where('uuid', $request->reviewed_id)->first();
        // dd($reviewedID);
        $reviewRequestData = [
            'reviewer_id' => auth()->id(),
            'reviewed_id' => $reviewedID->id,

        ];

        auth()->user()->reviewRequests()->attach($reviewedID->id, [
            'created_by' => auth()->id(),
            'is_done' => true,
        ]);
        $reviewFeedback = auth()->user()->reviewRequests->last()->pivot->feedback()->create($request->only(['feedback', 'rating']));
        $reviewFeedback->load(['request.reviewer', 'request.reviewed', 'request']);
        return new ReviewFeedbackShowResource($reviewFeedback);
    }

    /**
     * Update review feedback.
     *
     * @param  App\Http\Requests\UpdateReviewFeedbackRequest  $request
     * @param  ReviewFeedback $review_feedback
     * @return App\Http\Resources\ReviewFeedbackShowResource
     */
    public function update(UpdateReviewFeedbackRequest $request, ReviewFeedback $review_feedback)
    {
        $review_feedback->update($request->all());
        return new ReviewFeedbackShowResource($review_feedback);
    }
}

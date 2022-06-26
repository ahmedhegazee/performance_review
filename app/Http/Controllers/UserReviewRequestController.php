<?php

namespace App\Http\Controllers;

use App\Http\Requests\WriteReviewFeedbackRequest;
use App\Http\Resources\ReviewFeedbackShowResource;
use App\Http\Resources\UserReviewRequestResource;
use App\Models\ReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserReviewRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviewRequest = DB::table('review_requests')
            ->join('users as reviewed', 'reviewed.id', '=', 'review_requests.reviewed_id')
            ->join('users as createdBy', 'createdBy.id', '=', 'review_requests.created_by')
            ->where('review_requests.reviewer_id', '=', auth()->id())
            ->where('review_requests.is_done', '=', 0)
            ->select(['review_requests.id', 'review_requests.created_at', 'reviewed.name as reviewed', 'createdBy.name as createdBy'])
            ->get();
        return UserReviewRequestResource::collection($reviewRequest);
    }


    public function writeFeedback(WriteReviewFeedbackRequest $request, ReviewRequest $review_request)
    {
        if ($review_request->reviewer_id != auth()->id())
            abort(401);
        if ($review_request->is_done)
            abort(200, 'The feedback is written');
        $feedback = $review_request->feedback()->create($request->validated());
        $review_request->update(['is_done' => true]);
        return new ReviewFeedbackShowResource($feedback);
    }
}
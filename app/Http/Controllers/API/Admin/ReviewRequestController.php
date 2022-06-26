<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewRequestResource;
use App\Models\ReviewRequest;
use App\Models\User;
use App\Notifications\ReviewRequestCreatedNotification;

class ReviewRequestController extends Controller
{
    /**
     * Display a listing of review requests.
     *
     * @return App\Http\Resources\ReviewRequestResource
     */
    public function index()
    {
        $reviewRequests = ReviewRequest::with(['reviewer', 'reviewed', 'createdBy'])->latest()->paginate(10);
        return ReviewRequestResource::collection($reviewRequests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request)
    {
        $users = User::select(['id', 'uuid', 'name', 'is_admin'])
            ->whereIn('uuid', \array_values($request->validated()))
            ->get(['id', 'uuid', 'name', 'is_admin'])
            ->keyBy('uuid')
            ->all();
        $reviewer = $users[$request->reviewer_id];
        $reviewer->reviewRequests()
            ->attach($users[$request->reviewed_id]->id, ['created_by' => auth()->id()]);
        $reviewer->notify(new ReviewRequestCreatedNotification($users[$request->reviewed_id]->name));
    }

    /**
     * Display the specified resource.
     *
     * @param  ReviewRequest $review_request
     * @return App\Http\Resources\ReviewRequestResource
     */
    public function show(ReviewRequest $review_request)
    {
        $review_request->load(['reviewer', 'reviewed', 'createdBy']);
        return new ReviewRequestResource($review_request);
    }

    /**
     * Remove the review request.
     *
     * @param  ReviewRequest $review_request
     */
    public function destroy(ReviewRequest $review_request)
    {
        $review_request->delete();
    }
}
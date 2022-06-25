<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|numeric|min:1|max:10',
            'feedback' => 'required|string|min:10|max:2000',
            'reviewed_id' => 'required|uuid|exists:users,uuid',
        ];
    }
}
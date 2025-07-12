<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'report_id'     => 'required|exists:reports,id',
            'appeal_reason' => 'required|string|max:2000',
            'appeal_date'   => 'required|date',
            // Untuk review/update
            'appeal_status' => 'nullable|in:submitted,under_review,approved,rejected',
            'review_result' => 'nullable|string',
            'reviewed_by'   => 'nullable|exists:users,id',
            'review_date'   => 'nullable|date',
        ];
    }
}

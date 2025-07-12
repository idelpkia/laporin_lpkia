<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenaltyRequest extends FormRequest
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
            'report_id'        => 'required|exists:reports,id',
            'penalty_level_id' => 'required|exists:penalty_levels,id',
            'penalty_type'     => 'required|string|max:255',
            'description'      => 'nullable|string',
            'recommendation_date' => 'nullable|date',
            'decided_by'       => 'required|exists:users,id',
            'sk_number'        => 'nullable|string|max:255',
            'sk_date'          => 'nullable|date',
            'status'           => 'required|in:recommended,approved,executed',
        ];
    }
}

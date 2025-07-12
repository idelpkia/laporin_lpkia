<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenaltyLevelRequest extends FormRequest
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
        // unique pada level, abaikan id sekarang jika update
        return [
            'level'       => 'required|in:light,medium,heavy|unique:penalty_levels,level,' . $this->penalty_level,
            'description' => 'nullable|string',
        ];
    }
}

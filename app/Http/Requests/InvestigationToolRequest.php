<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestigationToolRequest extends FormRequest
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
            'tool_name'         => 'required|in:turnitin,grammarly,codequiry,jplag,lms_audit,git_audit',
            'result_file_path'  => 'nullable|string',
            'result_percentage' => 'nullable|numeric',
            'notes'             => 'nullable|string',
        ];
    }
}

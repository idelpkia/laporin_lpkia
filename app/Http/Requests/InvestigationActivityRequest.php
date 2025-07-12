<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestigationActivityRequest extends FormRequest
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
            'activity_type' => 'required|in:document_analysis,interview,similarity_check,metadata_audit',
            'description'   => 'nullable|string',
            'activity_date' => 'required|date',
            'performed_by'  => 'required|exists:users,id',
            'notes'         => 'nullable|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ViolationTypeRequest extends FormRequest
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
        $violationTypeId = $this->violation_type instanceof \App\Models\ViolationType
            ? $this->violation_type->id
            : $this->violation_type;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('violation_types', 'code')->ignore($violationTypeId),
            ],

            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'required|in:plagiarism,fabrication,collusion,document_forgery,ip_violation',
        ];
    }
}

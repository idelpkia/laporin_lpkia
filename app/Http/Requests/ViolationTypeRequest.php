<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'code'        => 'required|string|max:50|unique:violation_types,code,' . $this->violation_type,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'required|in:plagiarism,fabrication,collusion,document_forgery,ip_violation',
        ];
    }
}

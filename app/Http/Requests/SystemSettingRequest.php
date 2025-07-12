<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingRequest extends FormRequest
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
            'key'         => 'required|string|max:100|unique:system_settings,key,' . $this->system_setting,
            'value'       => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}

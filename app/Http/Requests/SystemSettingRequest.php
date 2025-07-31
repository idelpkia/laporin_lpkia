<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $settingId = $this->system_setting instanceof \App\Models\SystemSetting
            ? $this->system_setting->id
            : $this->system_setting;

        return [
            'key'         => [
                'required',
                'string',
                'max:100',
                Rule::unique('system_settings', 'key')->ignore($settingId),
            ],
            'value'       => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}

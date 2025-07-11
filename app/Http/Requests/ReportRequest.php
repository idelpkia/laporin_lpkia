<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
        $rules = [
            'report_number'        => 'nullable|string|unique:reports,report_number,' . $this->id,
            'title'                => 'required|string|max:255',
            'reported_person_name' => 'required|string|max:255',
            'reported_person_email' => 'nullable|email|max:255',
            'reported_person_type' => 'required|in:student,lecturer,staff,external',
            'violation_type_id'    => 'required|exists:violation_types,id',
            'description'          => 'nullable|string',
            'incident_date'        => 'nullable|date',
            'submission_method'    => 'required|in:online,offline',
            'status'               => 'required|in:submitted,validated,under_investigation,completed,rejected,appeal',
        ];

        // Tambahkan pengecualian untuk update (jika ada unique)
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['report_number'] = 'nullable|string|unique:reports,report_number,' . $this->route('report');
        }

        return $rules;
    }
}

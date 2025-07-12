<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommitteeMemberRequest extends FormRequest
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
        // unique: satu user hanya boleh ada satu record aktif sebagai anggota KIA
        return [
            'user_id'   => 'required|exists:users,id|unique:committee_members,user_id,' . $this->committee_member,
            'position'  => 'required|in:chairman,member,secretary',
            'is_active' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date'  => 'nullable|date|after_or_equal:start_date',
        ];
    }
}

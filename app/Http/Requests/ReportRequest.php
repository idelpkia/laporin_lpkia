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
        // dd($this->all());
        $rules = [
            'title'                => 'required|string|max:255',
            'reported_person_name' => 'required|string|max:255',
            'reported_person_email' => 'nullable|email|max:255',
            'reported_person_type' => 'required|in:student,lecturer,staff,external',
            'violation_type_id'    => 'required|exists:violation_types,id',
            'description'          => 'required|string',
            'incident_date'        => 'required|date',
            'submission_method'    => 'required|in:online,offline',

            // Validation untuk file upload - DIPERBAIKI
            'documents'            => 'nullable|array',
            'documents.*'          => 'nullable|file|max:20480|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mp3,zip,rar',
            'document_types'       => 'nullable|array',
            'document_types.*'     => 'nullable|string|in:evidence,similarity_report,original_document,screenshot,recording',
        ];

        // Untuk update, tambahkan validasi report_number jika diperlukan
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['report_number'] = 'nullable|string|unique:reports,report_number,' . $this->route('report');
        }

        return $rules;
    }
    /**
     * Validasi custom untuk memastikan array documents dan document_types sinkron
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $documents = $this->file('documents') ?? [];
            $documentTypes = $this->input('document_types') ?? [];

            // Pastikan jumlah documents dan document_types sama
            if (count($documents) !== count($documentTypes)) {
                $validator->errors()->add('documents', 'Jumlah dokumen dan tipe dokumen tidak sesuai.');
            }

            // Pastikan setiap documents memiliki document_types
            foreach ($documents as $index => $document) {
                if (!isset($documentTypes[$index])) {
                    $validator->errors()->add("document_types.{$index}", 'Tipe dokumen harus dipilih.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul laporan wajib diisi.',
            'reported_person_name.required' => 'Nama terlapor wajib diisi.',
            'reported_person_email.email' => 'Format email terlapor tidak valid.',
            'reported_person_type.required' => 'Jenis terlapor wajib dipilih.',
            'reported_person_type.in' => 'Jenis terlapor tidak valid.',
            'violation_type_id.required' => 'Jenis pelanggaran wajib dipilih.',
            'violation_type_id.exists' => 'Jenis pelanggaran tidak valid.',
            'incident_date.date' => 'Format tanggal kejadian tidak valid.',
            'submission_method.required' => 'Metode pengajuan wajib dipilih.',
            'submission_method.in' => 'Metode pengajuan tidak valid.',
            'documents.*.file' => 'File yang diupload harus berupa file.',
            'documents.*.max' => 'Ukuran file maksimal 10MB.',
            'documents.*.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
        ];
    }
}

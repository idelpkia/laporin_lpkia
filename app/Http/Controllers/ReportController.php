<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\ViolationType;
use App\Models\WorkflowLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('violationType')
            ->when(auth()->user()->role === 'student', function ($query) {
                $query->where('reporter_id', auth()->id());
            })
            ->latest()->paginate(10);

        return view('pages.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $violationTypes = ViolationType::all();
        return view('pages.reports.create', compact('violationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        try {
            // Ambil data yang sudah divalidasi
            $data = $request->validated();

            // Set data yang tidak ada di form
            $data['reporter_id'] = auth()->id();
            $data['report_number'] = $this->generateReportNumber();
            $data['status'] = 'submitted';

            // Hapus data yang tidak diperlukan untuk create report
            unset($data['documents'], $data['document_types']);

            // Buat laporan
            $report = Report::create($data);

            // Handle upload dokumen jika ada
            $this->handleDocumentUpload($request, $report);

            // Kirim notifikasi
            $this->notificationService->newReportNotification($report);

            return redirect()->route('reports.show', $report)
                ->with('success', 'Laporan berhasil dibuat dengan nomor: ' . $report->report_number);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report->load('violationType', 'reporter', 'reportDocuments');
        return view('pages.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        if ($report->status !== 'submitted') {
            return redirect()->route('reports.show', $report)->with('error', 'Laporan tidak dapat diedit.');
        }
        $violationTypes = ViolationType::all();
        return view('reports.edit', compact('report', 'violationTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, Report $report)
    {
        try {
            // Ambil data yang sudah divalidasi
            $data = $request->validated();

            // Hapus data yang tidak diperlukan untuk update
            unset($data['documents'], $data['document_types']);

            $oldStatus = $report->status;

            // Update laporan
            $report->update($data);

            // Handle upload dokumen baru jika ada
            $this->handleDocumentUpload($request, $report);

            // Jika status berubah, kirim notifikasi
            if ($oldStatus !== $report->status) {
                $this->notificationService->reportStatusUpdated($report, $oldStatus, $report->status);
            }

            return redirect()->route('reports.show', $report)
                ->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        // Cek hak akses dan status laporan
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }


    public function deleteDocument(Report $report, $documentId)
    {
        $document = $report->reportDocuments()->findOrFail($documentId);

        // Hapus file fisik dari storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('reports.show', $report)->with('success', 'Dokumen berhasil dihapus.');
    }

    public function changeStatus(Request $request, Report $report)
    {
        $request->validate([
            'to_status' => 'required|in:submitted,validated,under_investigation,completed,rejected,appeal',
            'notes'     => 'nullable|string',
        ]);

        $fromStatus = $report->status;
        $toStatus   = $request->to_status;

        // Update status di tabel report
        $report->update(['status' => $toStatus]);

        // Catat di workflow_log
        WorkflowLog::create([
            'report_id'   => $report->id,
            'from_status' => $fromStatus,
            'to_status'   => $toStatus,
            'action_by'   => auth()->id(),
            'notes'       => $request->notes,
            'created_at'  => now(),
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Status laporan diperbarui.');
    }

    // Tambahkan method ini untuk download
    public function downloadDocument(Report $report, $documentId)
    {
        $document = $report->reportDocuments()->findOrFail($documentId);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    // Perbaiki validasi addDocument
    public function addDocument(Request $request, Report $report)
    {
        $request->validate([
            'document_type' => 'required|in:evidence,similarity_report,original_document,screenshot,recording',
            'file' => 'required|file|max:20480|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mp3,zip,rar',
        ]);

        try {
            $filePath = $request->file('file')->store('report_documents', 'public');

            $document = $report->reportDocuments()->create([
                'document_type' => $request->document_type,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $request->file('file')->getSize(),
                'mime_type' => $request->file('file')->getMimeType(),
            ]);

            return redirect()->route('reports.show', $report)->with('success', 'Dokumen berhasil diupload.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Generate nomor laporan unik
     */
    private function generateReportNumber()
    {
        do {
            $reportNumber = 'RPT-' . date('Y') . date('m') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Report::where('report_number', $reportNumber)->exists());

        return $reportNumber;
    }

    /**
     * Handle upload dokumen
     */
    private function handleDocumentUpload(ReportRequest $request, Report $report)
    {
        if ($request->hasFile('documents')) {
            $documents = $request->file('documents');
            $documentTypes = $request->input('document_types', []);

            foreach ($documents as $key => $file) {
                // Pastikan file valid dan ada tipe dokumen yang sesuai
                if ($file && $file->isValid() && isset($documentTypes[$key])) {
                    $filePath = $file->store('report_documents', 'public');

                    $report->reportDocuments()->create([
                        'document_type' => $documentTypes[$key],
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $filePath,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }
        }
    }
}

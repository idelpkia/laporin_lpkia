<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\ViolationType;
use App\Models\WorkflowLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
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

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $violationTypes = ViolationType::all();
        return view('reports.create', compact('violationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        // Generate report_number jika perlu
        $data['report_number'] = $data['report_number'] ?? 'RPT-' . time() . '-' . rand(1000, 9999);

        $report = Report::create($data);

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil dibuat.');
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
        return view('reports.show', compact('report'));
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
        if ($report->status !== 'submitted') {
            return redirect()->route('reports.show', $report)->with('error', 'Laporan tidak dapat diedit.');
        }

        $data = $request->validated();
        $report->update($data);

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil diperbarui.');
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

    public function addDocument(Request $request, Report $report)
    {
        $request->validate([
            'document_type' => 'required|in:evidence,similarity_report,original_document,screenshot,recording',
            'file'          => 'required|file|max:20480', // max 20 MB
        ]);

        // Simpan file ke storage (bisa disesuaikan)
        $filePath = $request->file('file')->store('report_documents', 'public');

        $document = $report->reportDocuments()->create([
            'document_type' => $request->document_type,
            'file_name'     => $request->file('file')->getClientOriginalName(),
            'file_path'     => $filePath,
            'file_size'     => $request->file('file')->getSize(),
            'mime_type'     => $request->file('file')->getMimeType(),
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Dokumen berhasil diupload.');
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
}

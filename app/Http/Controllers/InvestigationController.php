<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestigationActivityRequest;
use App\Http\Requests\InvestigationRequest;
use App\Http\Requests\InvestigationToolRequest;
use App\Http\Requests\TeamMemberRequest;
use App\Models\Investigation;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investigations = Investigation::with('report', 'teamLeader')->paginate(10);
        return view('investigations.index', compact('investigations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reports = Report::where('status', 'under_investigation')->get();
        $users = User::all();
        return view('investigations.create', compact('reports', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvestigationRequest $request)
    {
        $data = $request->validated();
        $investigation = Investigation::create($data);

        return redirect()->route('investigations.show', $investigation)->with('success', 'Investigasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Investigation $investigation)
    {
        $investigation->load('report', 'teamLeader', 'investigationTeams.member', 'investigationActivities.performer', 'investigationTools');
        return view('investigations.show', compact('investigation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Investigation $investigation)
    {
        $users = User::all();
        return view('investigations.edit', compact('investigation', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvestigationRequest $request, Investigation $investigation)
    {
        $data = $request->validated();
        $investigation->update($data);

        return redirect()->route('investigations.show', $investigation)->with('success', 'Investigasi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investigation $investigation)
    {
        $investigation->delete(); // Soft delete
        return redirect()->route('investigations.index')->with('success', 'Investigasi berhasil dihapus.');
    }

    // --------- Nested: Team Member ----------

    public function addTeamMember(TeamMemberRequest $request, Investigation $investigation)
    {
        $data = $request->validated();
        $investigation->investigationTeams()->create($data);

        return back()->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function removeTeamMember(Investigation $investigation, $teamMemberId)
    {
        $teamMember = $investigation->investigationTeams()->findOrFail($teamMemberId);
        $teamMember->delete();

        return back()->with('success', 'Anggota tim berhasil dihapus.');
    }

    // --------- Nested: Activity ----------

    public function addActivity(InvestigationActivityRequest $request, Investigation $investigation)
    {
        $data = $request->validated();
        $investigation->investigationActivities()->create($data);

        return back()->with('success', 'Aktivitas investigasi berhasil ditambahkan.');
    }

    public function updateActivity(InvestigationActivityRequest $request, Investigation $investigation, $activityId)
    {
        $activity = $investigation->investigationActivities()->findOrFail($activityId);
        $data = $request->validated();
        $activity->update($data);

        return back()->with('success', 'Aktivitas investigasi berhasil diupdate.');
    }

    // --------- Nested: Tools ----------

    public function addTool(InvestigationToolRequest $request, Investigation $investigation)
    {
        $data = $request->validated();
        $investigation->investigationTools()->create($data);

        return back()->with('success', 'Tools investigasi berhasil ditambahkan.');
    }

    public function removeTool(Investigation $investigation, $toolId)
    {
        $tool = $investigation->investigationTools()->findOrFail($toolId);
        $tool->delete();

        return back()->with('success', 'Tools investigasi berhasil dihapus.');
    }
}

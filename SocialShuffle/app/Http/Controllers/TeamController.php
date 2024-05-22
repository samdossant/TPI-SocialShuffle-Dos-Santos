<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teams.index', ['teams' => Team::latest()->withCount('members')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.forms.nameForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(isset($request->name)){
            $teamName = $request->validate([
                'name' => 'required|string',
            ]);

            $team = Team::create($teamName);

            session([
                'currentTeam' => $team,
            ]);

            return view('members.createMembers', 
            [
                'team' => $team,
                'members' => $team->members()->get(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('teams.show', 
        [
            'team' => $team,
            'members' => $team->members()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateGroupsRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check())
        {
            return view('teams.index',
            [
                'userTeams' => Team::where('user_id', Auth::user()->id)->latest()->withCount('members')->get(),
                'allTeams' => Team::latest()->withCount('members')->get(),
            ]);
            
        }

        return view('teams.index', 
        [
            'allTeams' => Team::latest()->withCount('members')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.forms.name.nameForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        $validatedName = $request->validated();
        $validatedName['user_id'] = Auth::user()->id;

        // dd($validatedName);

        $team = Team::create($validatedName);

        return redirect()->route('team.members.create', 
        [
            'team' => $team,
        ]);
        
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
        return view('teams.forms.name.editName', ['team' => $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team)
    {
        $validatedName = $request->validated();

        $team->update($validatedName);

        return redirect()->route('team.show', ['team' => $team]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        // dd($team);
        $team->delete();

        return redirect()->route('team.index');
    }


    // Groups management

    public function groupForm(Team $team){
        return view('teams.forms.groups.createGroups', ['team' => $team]);
    }

    public function generateGroups(CreateGroupsRequest $request, Team $team)
    {
        $data = $request->validated();
    
        $members = $team->members;
        $totalGenerations = $data['nbActivities'];  // Nombre de générations d'activités
        $membersPerGroup = $data['nbMemberPerGroup'];  // Nombre de membres par groupe
        $totalMembers = count($members);
        


}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateGroupsRequest;
use App\Models\Member;

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
        if($team->groups()->exists()){

            // dd($groups);

            return view('teams.show', 
            [
                'team' => $team,
                'groups' => $team->groups()->orderBy('generation')->get(),
                'members' => $team->members()->get(),
            ]);
        }

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
        $totalGenerations = $data['nbActivities'];  // Number of generations
        $membersPerGroup = $data['nbMemberPerGroup'];  // Size of the group (numbre of members)
        $totalMembers = count($members);
        $notComplete = false;
        
        $membersId = $members->pluck('id')->toArray();
        
        // Contains all the generations
        $previousAssignments = [];
        
        // Cycle through each generation
        for($i = 0; $i < $totalGenerations; $i++)
        {
            $group = []; // Contains one group at a time
            $generationGroups = []; // Contains the groups of one gneration
            
            // Shuffle the members in a random order
            shuffle($membersId);
            
            // Cycle through each member
            foreach($membersId as $member){
                
                // Add the member to the group
                $group[] = $member;
                
                // Check if the number of stored members isn't higher than the defined group size
                if(count($group) >= $membersPerGroup){
                    
                    // Add the created group to the generation
                    $generationGroups[] = $group;
                    
                    // Reset the array
                    $group = [];
                }
            }
            
            // If the data doesn't allow to store the inputed number of members for the last groups, then store the uncomplete group in the generation.
            if($totalMembers % $membersPerGroup != 0){
                $generationGroups[] = $group;
                $notComplete = true;
            }
            
            // Store the generation
            $previousAssignments[] = $generationGroups;
        }
        
        // Create groups in database and associate the members
        foreach($previousAssignments as $generationIndex => $generationGroup){
            
            $i = 0;
            
            // dd($generationGroup);
            
            
            foreach($generationGroup as $groupMembers){
                $group = Group::create([
                    'generation' => $generationIndex,
                    'team_id' => $team->id,
                ]);
                foreach($groupMembers as $groupMember){
                    
                    // Find the member with its ID
                    $specificMember = Member::find($groupMember);
                    
                    // Associate the member to its group
                    $specificMember->groups()->attach($group);
                }
            }
        }

        $team->update([
            'nbActivities' => $totalGenerations,
            'nbMemberPerGroup' => $membersPerGroup,
        ]);
        
        return response()->json($previousAssignments);
    }    
}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateGroupsRequest;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check that user is authenticated to display their teams
        if(Auth::check())
        {
            return view('teams.index',
            [
                // Get only the teams that belong to the current user.
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
        // Check wether user is authenticated. If not throw error 401 (Unauthorized) 
        if(!Auth::check()){
            return abort(401);
        }
        return view('teams.name.nameForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        // Validate request
        $validatedName = $request->validated();

        // Add the current authentified user to the validated data array.
        $validatedName['user_id'] = Auth::user()->id;

        // Create a new team with mass assignement
        $team = Team::create($validatedName);

        return redirect()->route('team.members.create', 
        [
            'team' => $team,
        ]);
    }

    public function importCSV(Request $request, Team $team){
        $request->validate([
            'importCSV' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('importCSV');
        $handle = fopen($file->path(), 'r');

        // Skip file header
        fgetcsv($handle);

        $chunkSize = 25;
        while(!feof($handle))
        {
            $chunkData = [];

            for($i = 0; $i < $chunkSize; $i++)
            {
                $data = fgetcsv($handle);
                if($data === false)
                {
                    break;
                }
                $chunkData[] = $data; 
            }

            if(!$this->getChunkData($team, $chunkData)){
                return redirect()->back()->withErrors([
                    'ErrorInCSV' => 'Une erreur a été détectée dans le fichier CSV',
                ]);
            }
        }
        fclose($handle);

        return redirect()->route('team.members.create', 
        [
            'team' => $team,
            'members' => $team->members()->get(),
        ]);
    }

    public function getChunkData(Team $team, $chunkData){
        foreach($chunkData as $column){

            $validator = Validator::make([
                'firstname' => $column[0],
                'lastname' => $column[1],
                'email' => $column[2],
                'phone_number' => $column[3],
            ],
            [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|max:320',
                'phone_number' => 'required|string|min:9',
            ]);

            if($validator->fails()){
                return false;
            }

            $member = new Member();

            $member->firstname = $column[0];
            $member->lastname = $column[1];
            $member->email = $column[2];
            $member->phone_number = $column[3];
            $member->team_id = $team->id;
            $member->save();

        }
        return true;
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $qrCode = QrCode::size(100)
            ->generate(route('team.show', ['team' => $team]));
        // Checks that groups exist in the team
        if($team->groups()->exists()){

            return view('teams.show', 
            [
                'team' => $team,
                'groups' => $team->groups()->orderBy('generation')->get(),
                'members' => $team->members()->get(),
                'qrcode' => $qrCode,
            ]);
        }

        return view('teams.show', 
        [
            'team' => $team,
            'members' => $team->members()->get(),
            'qrcode' => $qrCode,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('teams.name.editName', ['team' => $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team)
    {
        if($request->user()->cannot('update', $team)){
            return abort(403);
        }

        $validatedName = $request->validated();

        // Update with mass assignement
        $team->update($validatedName);

        return redirect()->route('team.show', ['team' => $team]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Team $team)
    {
        if($request->user()->cannot('delete', $team)){
            return abort(403);
        }
        $team->delete();
        return redirect()->route('team.index');
    }

    public function csvDownload(){
        return Storage::disk('public')->download('CSV-Exemple.csv');
    }

    //---- Groups management ----

    /**
     * Show the form to enter the data related to the group generation
     */
    public function groupForm(Team $team){
        return view('groups.createGroups', ['team' => $team]);
    }

    public function generateGroups(CreateGroupsRequest $request, Team $team)
    {
        $data = $request->validated();

        // Check that members exist in the team
        if(!$team->members()->exists()){
            return redirect()->back()->withErrors(['other' => 'Aucun membre dans cette équipe.']);
        }

        $members = $team->members;
        $totalGenerations = $data['nbActivities'];  // Number of generations
        $membersPerGroup = $data['nbMemberPerGroup'];  // Size of the group (number of members)
        $totalMembers = count($members);

        $notCompleteGroupeSize = null;
        $notComplete = false;

        // Check that the specified group size isn't higher than the total number of members
        if($membersPerGroup > $totalMembers)
        {
            return redirect()->back()->withErrors(['other' => 'La taille des groupes spécifiée est plus grande que le nombre total de membres'])
                ->withInput($request->input());
        }

        if($totalMembers % $membersPerGroup != 0 && !$request->has('confirm')){
            return redirect()->back()->withInput($request->input())
                ->with(
                [
                    'confirm' => true, 
                    'notCompleteGroupeSize' => $totalMembers % $membersPerGroup,
                ]);
        }

        foreach($members as $member){
            if($member->groups()->exists())
            {
                $member->groups()->delete();
            }
        }
        
        $membersId = $members->pluck('id')->toArray();
        
        // Contains all the generations
        $previousAssignments = [];
        
        // Iterate through each generation
        for($i = 0; $i < $totalGenerations; $i++)
        {
            $group = []; // Contains one group at a time
            $generationGroups = []; // Contains the groups of one generation
            
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

            // If the data doesn't allow to store the inputed number 
            // of members for the last groups, then store the incomplete 
            //group in the generation.
            if($totalMembers % $membersPerGroup != 0){
                $generationGroups[] = $group;
            }
            
            // Store the generation
            $previousAssignments[] = $generationGroups;
        }

        // Create groups in database and associate the members
        foreach($previousAssignments as $generationIndex => $generationGroup){
            
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
            'nb_activities' => $totalGenerations,
            'group_size' => $membersPerGroup,
        ]);
        
        return redirect()->route('team.show', ['team' => $team]);
    }

    /**
     * Return the view that shows a specific generation
     */
    public function showActivity(Team $team, $generation){
        $qrCode = QrCode::size(100)
            ->generate(route('team.showActivity', ['team' => $team, 'generation' => $generation]));
        return view('teams.showActivity', 
            [
                'team' => $team,
                'groups' => $team->groups()->where('generation', $generation)->get(),
                'generation' => $generation,
                'qrCode' => $qrCode,
            ]);
    }
}

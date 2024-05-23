<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $team)
    {
        // Get the Members
        $members = Member::where('team_id', $team->id)->orderBy('lastname')->get();

        // Only send the members if they exist in the team
        if(!$members->isEmpty())
        {
            return view('members.createMembers', [
                'team' => $team,
                'members' => $members,
            ]);
        }

        return view('members.createMembers', [
            'team' => $team,
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request, Team $team)
    {
        // Validate the request containing the new member informations
        $data = $request->validated();

        // Create the member
        $team->members()->create($data);
        
        // Redirect to the form
        return redirect()->route('team.members.create', 
        [
            'team' => $team,
            'members' => $team->members()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team, Member $member)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team, Member $member)
    {
        return view('members.editMembers', [
            'team' => $team,
            'member' => $member,
            'members' => $team->members()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Team $team, Member $member)
    {
        $validatedMember = $request->validated();


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team, Member $member)
    {
        // dd($member);
        $member->delete();

        return redirect()->route('team.show', 
        [
            'team' => $team,
        ]);
    }
}

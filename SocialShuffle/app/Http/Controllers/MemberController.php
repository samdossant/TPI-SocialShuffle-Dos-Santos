<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Member;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
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
        // Validate the request containing the new member data
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
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team, Member $member)
    {
        if(!Auth::check() || Auth::user()->id != $team->user_id || !Auth::user()->admin){
            return abort(403);
        }

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
        if($request->user()->cannot('update', $team)){
            abort(403);
        }

        $validatedMember = $request->validated();

        $member->update($validatedMember);

        return redirect()->route('team.show', ['team' => $team]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team, Member $member)
    {
        // Delete the member
        $member->delete();

        return redirect()->route('team.show', ['team' => $team]);
    }
}

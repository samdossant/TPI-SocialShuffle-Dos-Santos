<?php

namespace App\Http\Controllers;

use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Delete the specified group
     */
    public function deleteGroup(Group $group){
        $group->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Group;

abstract class Controller
{
    public function deleteGroup(Group $group){
        $group->delete();
        return redirect()->back();
    }
}

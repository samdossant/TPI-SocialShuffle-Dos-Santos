<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nbActivities',
        'nbMemberPerGroup',
        'user_id',
    ];

    public function groups():HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}

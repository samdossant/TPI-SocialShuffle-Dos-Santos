<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'generation',
        'team_id',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function team():BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'generation',
        'team_id',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function team():BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

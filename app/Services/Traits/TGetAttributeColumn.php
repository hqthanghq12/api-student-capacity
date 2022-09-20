<?php

namespace App\Services\Traits;

use App\Models\Member;
use Illuminate\Support\Str;

trait TGetAttributeColumn
{
    public function  getSlugNameAttribute()
    {
        return Str::slug($this->name);
    }

    public function  getStatusUserHasJoinContestAttribute()
    {
        if (!auth('sanctum')->check()) return false;
        foreach ($this->teams as $team) {
            if (Member::where('team_id', $team->id)
                ->where('user_id', auth('sanctum')->id())->exists()
            )
                return true;
        }
        return false;
    }

    public function getUserStatusJoinAttribute()
    {
        if (!auth('sanctum')->check()) return false;
        foreach ($this->result_capacity as $result) {
            if ($result->user_id == auth('sanctum')->id())
                return $result->status;
        }
        return false;
    }
}
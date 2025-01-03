<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $table = "campuses";
    protected $fillable = ["name","	code","created_at","updated_at"];
    public function users()
    {
        return $this->hasMany(User::class, 'campus_id', 'code');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}

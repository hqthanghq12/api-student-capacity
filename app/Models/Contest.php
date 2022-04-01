<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Contest extends Model
{
    use HasFactory;
    protected $table = 'contests';
    public $fillable = [
        'name',
        'date_start',
        'register_deadline',
        'description',
        'major_id',
        'status',
    ];
    public function teams()
    {
        return $this->hasMany(Team::class, 'contest_id')->with('members');
    }
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function rounds()
    {
        return $this->hasMany(Round::class, 'contest_id');
    }
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}

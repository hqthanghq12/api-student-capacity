<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequest extends Model
{
    use HasFactory;

    protected $table = 'status_requests';

    protected $fillable = [
        'status',
        'semester_id',
        'campus_id',
        'poetry_id',
        'created_by',
    ];

    public function notes()
    {
        return $this->hasMany(StatusRequestNote::class);
    }
    
    public function histories()
    {
        return $this->hasMany(StatusRequestHistory::class);
    }

    public function poetry()
    {
        return $this->belongsTo(Poetry::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function semester()
    {
        return $this->belongsTo(semeter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

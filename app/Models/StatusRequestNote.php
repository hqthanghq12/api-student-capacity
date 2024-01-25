<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequestNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
    ];

    public function details()
    {
        return $this->hasMany(StatusRequestDetail::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequestDetail extends Model
{
    use HasFactory;

    protected $table = 'status_request_details';

    protected $fillable = [
        'status_request_note_id',
        'student_poetry_id',
        'note',
        'confirmed_by',
    ];

    public function statusRequest()
    {
        return $this->belongsTo(StatusRequest::class);
    }

    public function studentPoetry()
    {
        return $this->belongsTo(StudentPoetry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}

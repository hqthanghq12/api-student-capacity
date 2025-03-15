<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_request_id',
        'type',
        'created_by',
    ];

    public function statusRequest()
    {
        return $this->belongsTo(StatusRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

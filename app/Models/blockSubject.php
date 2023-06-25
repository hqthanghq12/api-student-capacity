<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blockSubject extends Model
{
    use HasFactory;
    protected $table = 'block_subject';
    protected $fillable = ['id_subject','id_block'];

    public function block(){
        return $this->hasOne(block::class, 'id','id_block');
    }
}

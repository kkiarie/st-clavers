<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksLogs extends Model
{
    use HasFactory;


    public function SubjectData()
    {
    return $this->belongsTo(SetupConfig::class,'subject_id','id');
    }
}

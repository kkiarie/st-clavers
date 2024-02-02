<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;


public function StudentData()
    {
    return $this->belongsTo(User::class,'student_id','id');
    }


public function ClassData()
    {
    return $this->belongsTo(SetupConfig::class,'class_id','id');
    }

public function StreamData()
    {
    return $this->belongsTo(SetupConfig::class,'stream_id','id');
    }

}

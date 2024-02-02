<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;



    public function ParentData()
    {
    return $this->belongsTo(User::class,'parent_id','id');
    }


    public function StudentData()
    {
    return $this->belongsTo(User::class,'student_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

        public function StudentData()
    {
    return $this->belongsTo(User::class,'student_id','id');
    }
}

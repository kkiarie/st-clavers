<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class SubjectTeacher extends Model
{
       use HasFactory;    
    use Sortable;


public $sortable = ['id','teacher_id','stream_id','class_id','academic_year','subject_id'];


    public function TeacherData()
    {
    return $this->belongsTo(User::class,'teacher_id','id');
    }

        public function ClassData()
    {
    return $this->belongsTo(SetupConfig::class,'class_id','id');
    }


    public function StreamData()
    {
    return $this->belongsTo(SetupConfig::class,'stream_id','id');
    }

        public function SubjectData()
    {
    return $this->belongsTo(SetupConfig::class,'subject_id','id');
    }

}

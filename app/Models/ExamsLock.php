<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class ExamsLock extends Model
{
      use HasFactory;    
    use Sortable;


     public $sortable = ['id','academic_year','term_id','close_date'];


    public function TermData()
    {
    return $this->belongsTo(SetupConfig::class,'term_id','id');
    }

    public function ExamData()
    {
    return $this->belongsTo(SetupConfig::class,'exam_id','id');
    }

}

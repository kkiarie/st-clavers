<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Grade extends Model
{
    use HasFactory;

        use Sortable;

    public $sortable = ['grade_id','remark_id','id','points_closing','points_opening','points'];




    public function GradeData()
{
return $this->belongsTo(SetupConfig::class,'grade_id','id');
}


public function RemarkData()
{
return $this->belongsTo(SetupConfig::class,'remark_id','id');
}

}

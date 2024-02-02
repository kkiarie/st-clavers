<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class FeeStructure extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = ['id','class_program','academic_stage_id','academic_year','fee_item','amount'];



    public function AcademicStageData()
    {
    return $this->belongsTo(SetupConfig::class,'academic_stage_id','id');
    }


    public function ClassProgramData()
    {
    return $this->belongsTo(SetupConfig::class,'class_program','id');
    }


    public function FeeData()
    {
    return $this->belongsTo(SetupConfig::class,'fee_item','id');
    }

    public function ProgramData()
    {
    return $this->belongsTo(Program::class,'program_id','id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class ProgramSubject extends Model
{
    use HasFactory;

        use Sortable;
    public $sortable = ['program_stage_id','created_at','id','program_unit_id'];


    public function ProgramStageData()
    {
    return $this->belongsTo(SetupConfig::class,'program_stage_id','id');
    }

        public function ProgamUnitData()
    {
    return $this->belongsTo(SetupConfig::class,'program_unit_id','id');
    }


        public function ProgamYear()
    {
    return $this->belongsTo(SetupConfig::class,'academic_level','id');
    }
}


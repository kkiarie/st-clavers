<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class FeePayment extends Model
{
    use HasFactory;    
    use Sortable;

    public $sortable = ['id','class_id','term_id','stream_id','gl_date','amount','ref'];

        public function FeeDataItem()
    {
    return $this->belongsTo(SetupConfig::class,'fee_structure_item_id','id');
    }


        public function StudentData()
    {
    return $this->belongsTo(User::class,'student_id','id');
    }


        public function AcademicStageData()
    {
    return $this->belongsTo(SetupConfig::class,'term_id','id');
    }


    public function ClassProgramData()
    {
    return $this->belongsTo(SetupConfig::class,'class_id','id');
    }


    public function FeeData()
    {
    return $this->belongsTo(SetupConfig::class,'fee_item','id');
    }


    public function PaymentModeData()
    {
    return $this->belongsTo(SetupConfig::class,'payment_mode_id','id');
    }


    public function issueData()
    {
    return $this->belongsTo(User::class,'created_by','id');
    }


    public function ProgramData()
    {
    return $this->belongsTo(Program::class,'program_id','id');
    }
}

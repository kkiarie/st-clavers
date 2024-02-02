<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamConfiguration extends Model
{
    use HasFactory;


    public function ExamItem()
    {
    return $this->belongsTo(SetupConfig::class,'item_id','id');
    }
}

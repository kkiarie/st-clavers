<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class StudentSubject extends Model
{
          use HasFactory;
        use Sortable;

    public $sortable = ['subject_id','id'];



    public function ClusterData()
    {
    return $this->belongsTo(SubjectCluster::class,'cluster_id','id');
    }


    public function SubjectData()
    {
    return $this->belongsTo(SetupConfig::class,'subject_id','id');
    }
}

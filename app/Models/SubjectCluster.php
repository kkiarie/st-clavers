<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class SubjectCluster extends Model
{
        use HasFactory;
        use Sortable;

    public $sortable = ['title','subject_id','id'];


  
}

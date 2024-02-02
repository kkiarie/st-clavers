<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class ResourceHubMaterial extends Model
{
     use Sortable;
    use HasFactory;


    public $sortable = ['id','created_at','program_stage_id','program_unit_id'];
}

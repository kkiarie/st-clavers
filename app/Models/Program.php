<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Program extends Model
{
    use HasFactory;


    use Sortable;
    public $sortable = ['name','created_at','id','program_level'];


    public function MetaData()
    {
    return $this->belongsTo(SetupConfig::class,'program_level','id');
    }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Notification extends Model
{
    use HasFactory;


        use Sortable;

    public $sortable = ['title','created_at','id','description','user_role'];



    public function RoleData()
    {
    return $this->belongsTo(SetupConfig::class,'user_role','id');
    }


}

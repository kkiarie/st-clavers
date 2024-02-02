<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class InventoryRequest extends Model
{
       use Sortable;
    use HasFactory;


    public $sortable = ['id','created_at','stock'];

           public function InventoryMasterData()
    {
        return $this->belongsTo(InventoryMaster::class,'inventory_masters_id','id');
    }
}

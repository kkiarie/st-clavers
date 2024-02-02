<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Procurement extends Model
{
    use Sortable;
    use HasFactory;

    public $sortable = ['rfp_code','quantity','created_at'];


        public function InventoryMasterData()
    {
        return $this->belongsTo(InventoryMaster::class,'inventory_masters_id','id');
    }



    public function CreaterData()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }



         public function ApprovalData()
    {
        return $this->belongsTo(User::class,'approved_by','id');
    }



}

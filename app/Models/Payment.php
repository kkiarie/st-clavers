<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Payment extends Model
{
    use HasFactory;
    use Sortable;



    public $sortable = ['ledger_code_id','amount','id','status'];



    public function sourceData()
    {
        return $this->belongsTo(LedgerCodeItem::class,'source','id');
    }


     public function destinationData()
    {
        return $this->belongsTo(LedgerCodeItem::class,'destination','id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class InventoryMaster extends Model
{
    use Sortable;
    use HasFactory;

    public $sortable = ['ledger_code_id','title','reorder_level','stock_level','id'];



    public function ledgerData()
    {
        return $this->belongsTo(LedgerCodeItem::class,'ledger_code_id','id');
    }
}

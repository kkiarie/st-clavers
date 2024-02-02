<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class InventoryTransactions extends Model
{
   use Sortable;
    use HasFactory;


    public $sortable = ['id','created_at','stock','transaction_type'];
}

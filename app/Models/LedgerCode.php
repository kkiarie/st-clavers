<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class LedgerCode extends Model
{
    use Sortable;
    use HasFactory;

    public $sortable = ['title','code','id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class LedgerCodeItem extends Model
{
    use Sortable;
    use HasFactory;

    public $sortable = ['title','code'];
}

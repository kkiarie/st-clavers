<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Menu extends Model
{
    use HasFactory;


    use Sortable;

    public $sortable = ['title','created_at','id'];




}

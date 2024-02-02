<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignMenu extends Model
{
    use HasFactory;



        public function MenuData()
    {
        return $this->belongsTo(Menu::class,'menu_id','id');
    }



            public function titleData()
    {
        return $this->belongsTo(SetupConfig::class,'user_id','id');
    }
}

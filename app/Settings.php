<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = ['ai92', 'ai95', 'ai98', 'dt', 'dtevro', 'gas'];
}

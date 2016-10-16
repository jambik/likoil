<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use ResourceableTrait;

    protected $table = 'campaigns';

    protected $fillable = ['name'];
}

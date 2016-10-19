<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use ResourceableTrait;

    protected $table = 'rates';

    protected $fillable = ['name', 'rate', 'start_at'];

    public static function findRateByName($fuelName)
    {
        return static::where('name', $fuelName)->first();
    }
}

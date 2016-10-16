<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use ResourceableTrait;

    protected $table = 'points';

    protected $fillable = ['points', 'DiscountCardID'];

    /**
     * Get product category.
     */
    public function card()
    {
        return $this->belongsTo('App\Card', 'DiscountCardID', 'DiscountCardID');
    }
}

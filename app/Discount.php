<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use ResourceableTrait;

    protected $table = 'discounts';

    protected $fillable = ['DiscountID', 'DiscountCardID', 'Date', 'Amount', 'Volume', 'Price', 'FuelName', 'AZSCode'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Get product category.
     */
    public function card()
    {
        return $this->belongsTo('App\Card', 'DiscountCardID', 'DiscountCardID');
    }
}

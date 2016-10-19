<?php

namespace App;

use App\Traits\ResourceableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use ResourceableTrait;

    protected $table = 'discounts';

    protected $fillable = [
        'id',
        'card_id',
        'date',
        'amount',
        'volume',
        'price',
        'fuel_name',
        'azs',
        'point',
        'rate',
        'start_at',
    ];

    /**
     * Get discount card.
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    public static function import($discountObject)
    {
        $point = 0;
        $rate = null;
        $startAt = null;

        if ($rateObj = Rate::findRateByName($discountObject->FuelName)) {
            $discountDate = Carbon::parse($discountObject->Date);

            if ($discountDate > $rateObj->start_at) {
                $startAt = $discountDate;
                $rate = $rateObj->rate;
                $point = ($startAt > $rateObj->start_at) ? $discountObject->Volume * $rateObj->rate : 0;
            }
        }

        $attributes = [
            'id' => $discountObject->DiscountID,
        ];

        $values = [
            'date' => $discountObject->Date,
            'card_id' => $discountObject->DiscountCardID,
            'amount' => $discountObject->Amount,
            'volume' => $discountObject->Volume,
            'price' => $discountObject->Price,
            'fuel_name' => $discountObject->FuelName,
            'azs' => $discountObject->AZSCode,
            'point' => $point,
            'rate' => $rate,
            'start_at' => $startAt,
        ];

        Discount::updateOrCreate($attributes, $values);
    }
}

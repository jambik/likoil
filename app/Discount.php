<?php

namespace App;

use App\Traits\ResourceableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="Discount",
 *      @SWG\Property(
 *          property="id",
 *          description="Id залива",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="card_id",
 *          description="Id карты",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="Дата залива",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="Сумма залива",
 *          type="number",
 *          format="float",
 *      ),
 *      @SWG\Property(
 *          property="volume",
 *          description="Объем залитого топлива",
 *          type="number",
 *          format="float",
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="Цена за литр",
 *          type="number",
 *          format="float",
 *      ),
 *      @SWG\Property(
 *          property="fuel_name",
 *          description="Код топлива",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="azs",
 *          description="Код АЗС",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="azs_address",
 *          description="Адрес АЗС",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="point",
 *          description="Начисленный бонус",
 *          type="number",
 *          format="float",
 *      ),
 *      @SWG\Property(
 *          property="start_at",
 *          description="Дата начала курса бонуса",
 *          type="string"
 *      )
 * )
 */
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
                $startAt = $rateObj->start_at;
                $rate = $rateObj->rate;
                $point = $discountObject->Volume * $rateObj->rate;
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

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Europe/Moscow')->toDateTimeString();
    }
}

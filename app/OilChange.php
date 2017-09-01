<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="OilChange",
 *      @SWG\Property(
 *          property="id",
 *          description="Id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="card_id",
 *          description="Id карты",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="mileage",
 *          description="Пробег авто",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="change_at",
 *          description="Дата смены масла",
 *          type="string"
 *      ),
 * )
 */

class OilChange extends Model
{
    use ResourceableTrait;

    protected $table = 'oil_change';

    protected $fillable = ['card_id', 'mileage', 'change_at'];

    /**
     * Get discount card.
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
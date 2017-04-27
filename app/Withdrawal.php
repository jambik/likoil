<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="Withdrawal",
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
 *          property="amount",
 *          description="Количество баллов",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="Тип операции",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="azs",
 *          description="АЗС",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="use_at",
 *          description="Дата снятия",
 *          type="string"
 *      ),
 * )
 */

class Withdrawal extends Model
{
    use ResourceableTrait;

    protected $table = 'withdrawals';

    protected $fillable = ['card_id', 'amount', 'type', 'azs', 'use_at'];

    public function getTypeAttribute($value)
    {
        return in_array($value, ['Бонус']) ? '+' : '-';
    }

    /**
     * Get discount card.
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}

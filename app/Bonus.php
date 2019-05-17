<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="Bonus",
 *      @SWG\Property(
 *          property="id",
 *          description="Id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="Количество добавленных баллов",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="comment",
 *          description="Комментарий",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="Дата добавления",
 *          type="string"
 *      ),
 * )
 */

class Bonus extends Model
{
    use ResourceableTrait;

    protected $table = 'bonus';

    protected $fillable = [
        'compaign_id', 'card_id', 'user_id', 'comment', 'amount',
    ];

    protected $hidden = [
        'compaign_id', 'card_id', 'user_id', 'updated_at',
    ];

    /**
     * Информация о карте
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * Информация о карте
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

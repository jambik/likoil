<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use ResourceableTrait;

    protected $table = 'cards';

    protected $fillable = ['id', 'code', 'transaction_id', 'verified'];

    protected $appends = ['bonus'];

    /**
     * Сумма всех снятых баллов
     */
    public function getTotalWithdrawalsAttribute()
    {
        return $this->withdrawals->sum('amount');
    }

    /**
     * Сумма всех начисленных баллов
     */
    public function getTotalPointsAttribute()
    {
        return $this->discounts->sum('point');
    }

    /**
     * Сумма всех начисленных баллов
     */
    public function getBonusAttribute()
    {
        return number_format($this->totalPoints - $this->totalWithdrawals, 2, '.', '');
    }

    /**
     * Снятые баллы
     */
    public function withdrawals()
    {
        return $this->hasMany('App\Withdrawal');
    }

    /**
     * Заливы
     */
    public function discounts()
    {
        return $this->hasMany('App\Discount');
    }

    /**
     * Информация о карте
     */
    public function info()
    {
        return $this->hasOne('App\CardInfo');
    }
}

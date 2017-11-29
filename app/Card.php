<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use ResourceableTrait;

    protected $table = 'cards';

    protected $fillable = ['id', 'code', 'transaction_id', 'verified', 'is_blocked'];

    protected $appends = ['bonus'];

    /**
     * Сумма всех снятых баллов
     */
    public function getTotalWithdrawalsAttribute()
    {
        $totalWithdrawals = $this->withdrawals->reduce(function ($carry, $item) {
            return $item->type == '-' ? $carry + $item->amount : $carry - $item->amount;
        });

        return $totalWithdrawals;
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
        return number_format($this->total_points - $this->total_withdrawals, 2, '.', '');
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
     * Замена масла
     */
    public function oilChanges()
    {
        return $this->hasMany('App\OilChange');
    }

    /**
     * Информация о карте
     */
    public function info()
    {
        return $this->hasOne('App\CardInfo');
    }
}

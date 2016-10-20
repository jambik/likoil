<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use ResourceableTrait;

    protected $table = 'cards';

    protected $fillable = ['id', 'code', 'transaction_id', 'name', 'gender', 'phone', 'birthday_at', 'verified'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var integer
     */
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
        return $this->totalPoints - $this->totalWithdrawals;
    }

    /**
     * Снятые баллов
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
}

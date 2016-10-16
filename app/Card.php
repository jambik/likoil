<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use ResourceableTrait;

    protected $table = 'cards';

    protected $fillable = ['DiscountCardID', 'Code', 'TransactionID', 'name', 'gender', 'phone', 'birthday_at', 'verified'];
}

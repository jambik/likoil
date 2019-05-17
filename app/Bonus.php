<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use ResourceableTrait;

    protected $table = 'bonus';

    protected $fillable = [
        'compaign_id', 'card_id', 'amount',
    ];

}

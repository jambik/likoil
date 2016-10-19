<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use ResourceableTrait;

    protected $table = 'withdrawals';

    protected $fillable = ['card_id', 'amount', 'type', 'azs', 'use_at'];

    /**
     * Get discount card.
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}

<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use ResourceableTrait;

    protected $table = 'notifications';

    protected $fillable = ['message', 'response', 'user_id'];

    /**
     * Пользователь
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

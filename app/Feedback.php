<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use ResourceableTrait;

    protected $table = 'feedbacks';

    protected $fillable = ['message', 'user_id'];

    /**
     * Пользователь
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
{
    use ResourceableTrait;

    protected $table = 'cards_info';

    protected $primaryKey = 'card_id';

    protected $appends = ['full_name'];

    protected $fillable = [
        'card_id',
        'name',
        'last_name',
        'patronymic',
        'gender',
        'phone',
        'birthday_at',
        'card_number',
        'issue_place',
        'type',
        'issued_at',
        'document_type',
        'document_number',
        'document_at',
        'document_issued',
        'car_brand',
        'car_number',
        'indate_at',
    ];

    public function getGenderAttribute($value)
    {
        return $value == 1 ? 'М' : ($value == 2 ? 'Ж' : '');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['last_name'] . ' ' . $this->attributes['name'] . ' ' . $this->attributes['patronymic'];
    }

    /**
     * Карта
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}

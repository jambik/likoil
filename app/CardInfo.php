<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
{
    use ResourceableTrait;

    protected $table = 'cards_info';

    protected $primaryKey = 'card_id';

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

    /**
     * Карта
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}

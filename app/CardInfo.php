<?php

namespace App;

use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="CardInfo",
 *      @SWG\Property(
 *          property="card_id",
 *          description="Id карты",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="Имя",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_name",
 *          description="Фамилия",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="patronymic",
 *          description="Отчество",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="gender",
 *          description="Пол",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="Телефон",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="birthday_at",
 *          description="Дата рождения",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="card_number",
 *          description="Внутренний номер карты",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="issue_place",
 *          description="Место выдачи",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="Тип",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="issued_at",
 *          description="Дата выдачи",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="document_type",
 *          description="Вид документа",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="document_number",
 *          description="Номер документа",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="document_at",
 *          description="Дата выдачи документа",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="document_issued",
 *          description="Кем выдан документ",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="car_brand",
 *          description="Марка автомобиля",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="car_number",
 *          description="Номер автомобиля",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="indate_at",
 *          description="Внутренняя дата",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="full_name",
 *          description="Полное имя (ФИО)",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="gender_letter",
 *          description="Буква пола (М, Ж)",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="gender_letters",
 *          description="Название пола (Мужской, Женский)",
 *          type="string"
 *      ),
 * )
 */
class CardInfo extends Model
{
    use ResourceableTrait;

    protected $table = 'cards_info';

    protected $primaryKey = 'card_id';

    protected $appends = ['full_name', 'gender_letter', 'gender_letters'];

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
        'password',
        'user_id',
    ];

    protected $hidden = [ 'password' ];

    public function getGenderLetterAttribute()
    {
        return $this->attributes['gender'] == 1 ? 'М' : ($this->attributes['gender'] == 2 ? 'Ж' : '');
    }

    public function getGenderLettersAttribute()
    {
        return $this->attributes['gender'] == 1 ? 'Мужской' : ($this->attributes['gender'] == 2 ? 'Женский' : '');
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

    /**
     * Пользователь
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use App\Traits\ResourceableTrait;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="GasStation",
 *      @SWG\Property(
 *          property="name",
 *          description="Название АЗС",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="city",
 *          description="Местоположение (Город)",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="Адрес",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="Телефон",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="lat",
 *          description="Широта",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="lng",
 *          description="Доолгота",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tags_service",
 *          description="Услуги",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tags_fuel",
 *          description="Виды топлива",
 *          type="string"
 *      )
 * )
 */
class GasStation extends Model
{
    use ResourceableTrait, Taggable;

    protected $table = 'gas_station';

    protected $fillable = ['name', 'city', 'address', 'phone', 'lat', 'lng', 'tags_service', 'tags_fuel'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function getTagsServiceStringAttribute()
    {
        return implode(',', $this->tags->pluck('name')->all());
    }

    public function getTagsFuelStringAttribute()
    {
        return implode(',', $this->tags->pluck('name')->all());
    }
}

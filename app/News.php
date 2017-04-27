<?php

namespace App;

use App\Traits\ImageableTrait;
use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="News",
 *      @SWG\Property(
 *          property="title",
 *          description="Заголовок новости",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="text",
 *          description="Текст новости",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="icon",
 *          description="Иконка новости (120px x 120px)",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="published_at",
 *          description="Дата публикации новости",
 *          type="string"
 *      )
 * )
 */
class News extends Model
{
    use ImageableTrait, ResourceableTrait;

    protected $table = 'news';

    protected $fillable = ['title', 'text', 'image', 'published_at'];

    protected $hidden = ['id', 'created_at', 'updated_at', 'img_url', 'image'];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $appends = ['img_url', 'icon'];

    public function getIconAttribute()
    {
        return request()->server('HTTP_HOST').'/images/small/'.$this->img_url.$this->image;
    }
}

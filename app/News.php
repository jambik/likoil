<?php

namespace App;

use App\Traits\ImageableTrait;
use App\Traits\ResourceableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="News",
 *      @SWG\Property(
 *          property="id",
 *          description="ID новости",
 *          type="integer"
 *      ),
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
 *          property="is_read",
 *          description="Статус новости",
 *          type="integer"
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

    protected $fillable = ['title', 'text', 'image', 'is_read', 'published_at'];

    protected $hidden = ['created_at', 'updated_at', 'img_url', 'image'];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $appends = ['img_url', 'icon'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_news', 'news_id', 'user_id');
    }

    public function getIconAttribute()
    {
        return $this->image ? (request()->server('HTTPS') ? 'https://' : 'http://').request()->server('HTTP_HOST').'/images/original/'.$this->img_url.$this->image : '';
    }
}

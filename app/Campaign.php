<?php

namespace App;

use App\Traits\ResourceableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use ResourceableTrait;

    protected $table = 'campaigns';

    protected $fillable = [
        'name', 'start_at', 'end_at', 'time_start', 'time_end', 'rate', 'days'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function azs()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function fuels()
    {
        return $this->belongsToMany('App\Rate')->withTimestamps();
    }

    public function getAzsIdsAttribute()
    {
        return $this->azs->pluck('id')->all();
    }

    public function getAzsNamesAttribute()
    {
        return implode(', ', $this->azs->pluck('name')->all());
    }

    public function getFuelsIdsAttribute()
    {
        return $this->fuels->pluck('id')->all();
    }

    public function getFuelsNamesAttribute()
    {
        return implode(', ', $this->fuels->pluck('name')->all());
    }

    public function setTimeStartAttribute($value)
    {
        $seconds = 0;

        if ($value) {
            $parsed = date_parse($value);
            $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60;
        }

        $this->attributes['time_start'] = $seconds;
    }

    public function getTimeStartAttribute($value)
    {
        return $value ? gmdate("H:i", $value) : '';
    }

    public function setTimeEndAttribute($value)
    {
        $seconds = 0;

        if ($value) {
            $parsed = date_parse($value);
            $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60;
        }

        $this->attributes['time_end'] = $seconds;
    }

    public function getTimeEndAttribute($value)
    {
        return $value ? gmdate("H:i", $value) : '';
    }

    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = $value ? implode(',', $value) : '';
    }

    public function getDaysAttribute($value)
    {
        $days = collect([
            0 => 'Воскресенье',
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
        ]);

        $daysNames = '';
        $daysIds = explode(',', $value);

        if ($daysIds) {
            $daysNames = $days->only($daysIds);
            $daysNames = $daysNames->implode(', ');
        }

        return $daysNames;
    }
}

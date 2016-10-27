<?php

namespace App;

use App\Traits\ResourceableTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use ResourceableTrait;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public function getPermissionsIdsAttribute()
    {
        return $this->perms->pluck('id')->all();
    }

    public function getPermissionsNamesAttribute()
    {
        return implode(', ', $this->perms->pluck('name')->all());
    }

    public function getPermissionsDisplayNamesAttribute()
    {
        return implode(', ', $this->perms->pluck('display_name')->all());
    }
}
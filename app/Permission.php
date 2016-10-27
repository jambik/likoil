<?php namespace App;

use App\Traits\ResourceableTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use ResourceableTrait;

    protected $table = 'permissions';

    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
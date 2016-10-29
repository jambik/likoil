<?php

namespace App;

use App\Traits\ImageableTrait;
use App\Traits\ResourceableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait, ImageableTrait, ResourceableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'email', 'role_id', 'phone', 'password', 'provider_id', 'provider', 'avatar', 'image', 'api_token' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token', 'api_token' ];

    protected $table = 'users';

    protected $appends = ['img_url'];

    /**
     * Дисконтная карта пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cardInfo()
    {
        return $this->hasOne('App\CardInfo');
    }

    public function getRolesNamesAttribute()
    {
        return implode(', ', $this->roles->pluck('display_name')->all());
    }

    public function getAvatarAttribute($value)
    {
        return $this->image ? '/images/small/' . $this->img_url . $this->image : $value;
    }

    /**
     * @param $userData
     * @return static
     */
    public static function findByEmailOrCreate($userData)
    {
        $user = User::where('email', $userData->email)->first();

        if( ! $user)
        {
            $user = User::create([
                'provider_id' => $userData->id,
                'provider' => $userData->provider,
                'name' => $userData->name,
                'email' => $userData->email,
                'avatar' => $userData->avatar,
            ]);
        }

        static::checkIfUserNeedsUpdating($userData, $user);

        return $user;
    }

    /**
     * @param $userData
     * @param $user
     */
    public static function checkIfUserNeedsUpdating($userData, $user)
    {
        $socialData = [
            'provider_id' => $userData->id,
            'provider'    => $userData->provider,
            'name'        => $userData->name,
            'avatar'      => $userData->avatar,
        ];
        $dbData = [
            'provider_id' => $user->provider_id,
            'provider'    => $user->provider,
            'name'        => $user->name,
            'avatar'      => $user->avatar,
        ];

        if ( ! empty(array_diff($socialData, $dbData)))
        {
            $user->provider_id = $userData->id;
            $user->provider    = $userData->provider;
            $user->name        = $userData->name;
            $user->avatar      = $userData->avatar;
            $user->save();
        }
    }
}

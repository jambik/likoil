<?php

namespace App\Http\Controllers\Auth\Social;

use App\User;
use Flash;
use Illuminate\Contracts\Auth\Guard;
use Socialite;
use Illuminate\Routing\Controller;

class YandexAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('yandex')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param Guard $auth
     * @return Response
     */
    public function handleProviderCallback(Guard $auth)
    {
        $userData = Socialite::driver('yandex')->user();
        $userData->provider = "yandex";
        $userData->name = $userData->name ?: $userData->user['display_name'];
        $userData->email = $userData->email ?: $userData->user['default_email'];
        $userData->avatar = $userData->avatar ?: "http://avatars.mds.yandex.net/get-yapic/".$userData->user['default_avatar_id']."/islands-50";

        $user = User::findByEmailOrCreate($userData);

        $auth->login($user, true);

        Flash::success("Выполнен вход через Яндекс");

        return redirect(route('index'));
    }
}

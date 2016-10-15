<?php

namespace App\Http\Controllers\Auth\Social;

use App\User;
use Flash;
use Illuminate\Contracts\Auth\Guard;
use Socialite;
use Illuminate\Routing\Controller;

class GitHubAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param Guard $auth
     * @return Response
     */
    public function handleProviderCallback(Guard $auth)
    {
        $userData = Socialite::driver('github')->user();
        $userData->provider = "github";
        $userData->name = $userData->name ?: $userData->nickname;
        $userData->email = $userData->email ?: '';
        $userData->avatar = $userData->avatar ?: '';

        $user = User::findByEmailOrCreate($userData);

        $auth->login($user, true);

        Flash::success("Выполнен вход через GitHub");

        return redirect(route('index'));
    }
}

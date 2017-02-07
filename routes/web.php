<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* ------------------------------------------- Admin routes --------------------------------------------------------- */
Route::group(['prefix' => 'admin'], function()
{
    ## Admin login/logout
    Route::get('login', ['as' => 'admin.login', 'uses' =>'Admin\Auth\LoginController@showAdminLoginForm']);
    Route::post('login', ['as' => 'admin.login.post', 'uses' =>'Admin\Auth\LoginController@login']);
    Route::post('logout', ['as' => 'admin.logout', 'uses' =>'Admin\Auth\LoginController@logout']);

    ## Models routes
    Route::group(['middleware' => 'admin'], function()
    {
        ## Admin index
        Route::get('/', ['as' => 'admin', 'uses' =>'Admin\IndexController@index']);

        ## Settings
        Route::get('settings', ['as' => 'admin.settings', 'uses' =>'Admin\SettingsController@index']);
        Route::post('settings', ['as' => 'admin.settings.save', 'uses' =>'Admin\SettingsController@save']);

        ## Web Settings
        Route::get('web_settings', ['as' => 'admin.web_settings', 'uses' =>'Admin\WebSettingsController@index']);
        Route::post('web_settings', ['as' => 'admin.web_settings.save', 'uses' =>'Admin\WebSettingsController@save']);

        ## Initialization
        Route::get('initialization', ['as' => 'admin.initialization', 'uses' =>'Admin\InitializationController@index']);
        Route::post('initialization', ['as' => 'admin.initialization.save', 'uses' =>'Admin\InitializationController@save']);

        ## Delete card
        Route::get('delete', ['as' => 'admin.delete', 'uses' =>'Admin\DeleteController@index']);
        Route::post('delete', ['as' => 'admin.delete.post', 'uses' =>'Admin\DeleteController@post']);

        Route::group(['as' => 'admin.'], function ()
        {
            ## Cards
            Route::resource('cards', 'Admin\CardsController');
            Route::get('cards/{id}/info', ['as' => 'cards.info', 'uses' =>'Admin\CardsController@showInfo'])->where('id', '[0-9]+');
            Route::post('cards/{id}/info', ['as' => 'cards.info.save', 'uses' =>'Admin\CardsController@saveInfo'])->where('id', '[0-9]+');
            Route::get('cards/{id}/login', ['as' => 'cards.login', 'uses' =>'Admin\CardsController@showLogin'])->where('id', '[0-9]+');
            Route::post('cards/{id}/login', ['as' => 'cards.login.save', 'uses' =>'Admin\CardsController@saveLogin'])->where('id', '[0-9]+');

            ## Discounts
            Route::resource('discounts', 'Admin\DiscountsController');

            ## Withdrawals
            Route::resource('withdrawals', 'Admin\WithdrawalsController');

            ## Points
            Route::resource('points', 'Admin\PointsController');

            ## Campaigns
            Route::resource('campaigns', 'Admin\CampaignsController');

            ## Rates
            Route::resource('rates', 'Admin\RatesController');

            ## Users import
            Route::resource('users_export', 'Admin\UsersExportController');

            ## Users AZS
            Route::resource('users_azs', 'Admin\UsersAzsController');

            ## Pages
            Route::resource('pages', 'Admin\PagesController');

            ## Blocks
            Route::resource('blocks', 'Admin\BlocksController');

            ## News
            Route::resource('news', 'Admin\NewsController');

            ## Users
            Route::resource('users', 'Admin\UsersController');

            ## Administrators
            Route::resource('administrators', 'Admin\AdministratorsController');

            ## Roles
            Route::resource('roles', 'Admin\RolesController');

            ## Permissions
            Route::resource('permissions', 'Admin\PermissionsController');
        });

        ## Imageable routes
        Route::delete('imageable', ['as' => 'imageable.delete', 'uses' => 'Admin\ImageableController@delete']);

        ## Headerable routes
        Route::delete('headerable', ['as' => 'headerable.delete', 'uses' => 'Admin\HeaderableController@delete']);
    });
});

/* --------------------------------------------- App routes --------------------------------------------------------- */
Route::group([], function ()
{
    ## Authentication / Registration / Password Reset
    Auth::routes();

    ## Index
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

    # Feedback
    Route::get('feedback', ['as' => 'feedback', 'uses' => 'CommonController@feedback']);
    Route::post('feedback', ['as' => 'feedback.send', 'uses' => 'CommonController@feedbackSend']);

    ## Callback
    Route::post('callback', ['as' => 'callback', 'uses' => 'CommonController@callback']);

    ## Pages
    Route::get('page/{slug}', ['as' => 'page.show', 'uses' => 'PagesController@show']);

    ## News
    Route::get('news', ['as' => 'news', 'uses' => 'NewsController@index']);
    Route::get('news/{id}', ['as' => 'news.show', 'uses' => 'NewsController@show']);

    ## Profile routes
    Route::group(['middleware' => 'auth'], function ()
    {
        Route::get('profile/personal', ['as' => 'profile.personal', 'uses' => 'ProfileController@personalShow']); // personal data
        Route::post('profile/personal', ['as' => 'profile.personal.save', 'uses' => 'ProfileController@personalSave']); // personal data save
        Route::get('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@passwordShow']); // change password form
        Route::post('profile/password', ['as' => 'profile.password.save', 'uses' => 'ProfileController@passwordSave']); // change password save
        Route::get('profile/avatar', ['as' => 'profile.avatar', 'uses' => 'ProfileController@avatarShow']); // avatar
        Route::post('profile/avatar', ['as' => 'profile.avatar.save', 'uses' => 'ProfileController@avatarSave']); // avatar save
    });

    ## Social routes
    Route::get('auth/github', 'Auth\Social\GitHubAuthController@redirectToProvider');
    Route::get('auth/github/callback', 'Auth\Social\GitHubAuthController@handleProviderCallback');
    Route::get('auth/twitter', 'Auth\Social\TwitterAuthController@redirectToProvider');
    Route::get('auth/twitter/callback', 'Auth\Social\TwitterAuthController@handleProviderCallback');
    Route::get('auth/facebook', 'Auth\Social\FacebookAuthController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\Social\FacebookAuthController@handleProviderCallback');
    Route::get('auth/vkontakte', 'Auth\Social\VkontakteAuthController@redirectToProvider');
    Route::get('auth/vkontakte/callback', 'Auth\Social\VkontakteAuthController@handleProviderCallback');
    Route::get('auth/yandex', 'Auth\Social\YandexAuthController@redirectToProvider');
    Route::get('auth/yandex/callback', 'Auth\Social\YandexAuthController@handleProviderCallback');
    Route::get('auth/odnoklassniki', 'Auth\Social\OdnoklassnikiAuthController@redirectToProvider');
    Route::get('auth/odnoklassniki/callback', 'Auth\Social\OdnoklassnikiAuthController@handleProviderCallback');
    Route::get('auth/mailru', 'Auth\Social\MailRuAuthController@redirectToProvider');
    Route::get('auth/mailru/callback', 'Auth\Social\MailRuAuthController@handleProviderCallback');
    Route::get('auth/google', 'Auth\Social\GoogleAuthController@redirectToProvider');
    Route::get('auth/google/callback', 'Auth\Social\GoogleAuthController@handleProviderCallback');

    ## Sitemap
    Route::get('sitemap.xml', 'SitemapController@index');
});
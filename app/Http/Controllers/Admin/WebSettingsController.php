<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\WebSettings;
use Flash;
use Illuminate\Http\Request;

class WebSettingsController extends BackendController
{
    public function index()
    {
        $settings = WebSettings::findOrNew(1);

        if( ! $settings->id)
        {
            $settings->email = 'jambik@gmail.com';
            $settings->phone = '+71234567890';
            $settings->description = 'Описание сайта';
        }

        return view('admin.web_settings.index', compact('settings'));
    }

    public function save(Request $request)
    {
        $settings = WebSettings::findOrNew(1);
        $settings->id = 1;
        $settings->fill($request->all());
        $settings->save();

        Flash::success("Настройки сохранены ");

        return redirect(route('admin.web_settings'));
    }
}
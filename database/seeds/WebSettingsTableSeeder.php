<?php

use App\WebSettings;
use Illuminate\Database\Seeder;

class WebSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new WebSettings();
        $settings->email       = 'jambik@gmail.com';
        $settings->phone       = '+79123456789';
        $settings->description = '<p>Описание сайта</p>';
        $settings->save();
    }
}

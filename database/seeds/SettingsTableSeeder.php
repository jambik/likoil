<?php

use App\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new Settings();
        $settings->ai92 = 10;
        $settings->ai95 = 10;
        $settings->ai98 = 10;
        $settings->dt = 10;
        $settings->dtevro = 10;
        $settings->gas = 5;
        $settings->save();
    }
}

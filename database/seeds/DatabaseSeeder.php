<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(BlocksTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(WebSettingsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(RatesTableSeeder::class);
    }
}

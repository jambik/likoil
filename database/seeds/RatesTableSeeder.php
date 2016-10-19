<?php

use App\Rate;
use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    protected $items = [
        ['Аи92', '0.5', '2014-01-01 00:00:00'],
        ['Аи95', '0.5', '2014-01-01 00:00:00'],
        ['Аи98', '0.5', '2014-01-01 00:00:00'],
        ['ДТ', '0.5', '2014-01-01 00:00:00'],
        ['ДТев', '0.5', '2014-01-01 00:00:00'],
        ['Газ', '0', '2014-01-01 00:00:00'],
        ['Экто92', '0.5', '2014-01-01 00:00:00'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0, $iMax=count($this->items); $i<$iMax; $i++)
        {
            $row = array_combine(['name', 'rate', 'start_at'], $this->items[$i]);

            Rate::create($row);
        }
    }
}

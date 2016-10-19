<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $items = [

        [1, 'Джанбулат Магомаев', 'jambik@gmail.com', 'user-1.jpg'],
        [2, 'Малик', 'nmm888@gmail.com', ''],
        [3, 'Руслан', 'intex05@bk.ru', ''],
        [4, 'Топаз Малик', 'topaz@export.likoil', ''],
        [5, 'АЗС 1', '1@azs.likoil', ''],
        [6, 'Стас', 'stas-group@yandex.ru', ''],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Администратор'; // optional
        $admin->description  = ''; // optional
        $admin->save();

        $roleExport = new Role();
        $roleExport->name         = 'export';
        $roleExport->display_name = 'Пользователь выгрузки';
        $roleExport->description  = 'Имеет право выгружать данные';
        $roleExport->save();

        $roleAzs = new Role();
        $roleAzs->name         = 'azs';
        $roleAzs->display_name = 'Пользователь АЗС';
        $roleAzs->description  = 'Имеет доступ к Api как пользователь АЗС';
        $roleAzs->save();

        $row1 = array_combine(['id', 'name', 'email', 'image'], $this->items[0]) + ['password' => bcrypt('111111')];
        $user1 = User::create($row1);
        $user1->attachRole($admin);

        $row2 = array_combine(['id', 'name', 'email', 'image'], $this->items[1]) + ['password' => bcrypt('malikmalik')];
        $user2 = User::create($row2);
        $user2->attachRole($admin);

        $row3 = array_combine(['id', 'name', 'email', 'image'], $this->items[2]) + ['password' => bcrypt('ruslanruslan')];
        $user3 = User::create($row3);
        $user3->attachRole($admin);

        $row4 = array_combine(['id', 'name', 'email', 'image'], $this->items[3]) + ['password' => bcrypt('jlk23452uy32')];
        $user4 = User::create($row4);
        $user4->attachRole($roleExport);

        $row5 = array_combine(['id', 'name', 'email', 'image'], $this->items[4]) + ['password' => bcrypt('azs1azs1')];
        $user5 = User::create($row5);
        $user5->attachRole($roleAzs);

        $row6 = array_combine(['id', 'name', 'email', 'image'], $this->items[5]) + ['password' => bcrypt('stustasstu')];
        $user6 = User::create($row6);
        $user6->attachRole($admin);
    }
}

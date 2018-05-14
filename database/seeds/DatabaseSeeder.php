<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //$this->call('TestTableSeeder');
        $this->call('UserTypeTableSeeder');
        $this->command->info('Таблица test загружена данными!');
    }
}

class TestTableSeeder extends Seeder {

    public function run()
    {
        DB::table('mytests')->delete();
        \App\mytest::create(['test' => 'Первое поле','test2' => 'Second поле']);
    }

}

class UserTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user_types')->delete();
        \App\userType::create(['alias' => 'admin','name' => 'Администратор']);
        \App\userType::create(['alias' => 'employee','name' => 'Сотрудник']);
        \App\userType::create(['alias' => 'visitor','name' => 'Посетитель']);
    }

}
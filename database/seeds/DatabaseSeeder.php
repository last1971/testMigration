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

        //$this->call('UserTypeTableSeeder');
        //$this->call('RubSeeder');
        //$this->call('PriceTypeSeeder');
        $this->call('DocumentTypeSeeder');
        $this->command->info('Таблица test загружена данными!');
    }
}
class DocumentTypeSeeder extends Seeder
{
    public function run(){
        DB::table('document_types')->insert([
            'name' => 'Корзина',
            'alias' => 'basket'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Продажа',
            'alias' => 'sale'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Счет',
            'alias' => 'invoice'
        ]);
        DB::table('document_types')->insert([
            'name' => 'УПД',
            'alias' => 'utd'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Перемещение',
            'alias' => 'movement'
        ]);
    }
}

class PriceTypeSeeder extends Seeder
{
    public function run(){
        DB::table('price_types')->insert([
            'name' => 'Входная цена',
            'alias' => 'in'
        ]);
        DB::table('price_types')->insert([
            'name' => 'Обычная продажная цена',
            'alias' => 'out'
        ]);
    }
}

class RubSeeder extends Seeder
{

    public function run()
    {
        DB::table('valutes')->insert([
        'name' => 'Рубль',
        'char_code' => 'RUR',
        'num_code' => 810,
        'cbr_id' => 'R00000',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('valutes')->insert([
            'name' => 'Доллар США',
            'char_code' => 'USD',
            'num_code' => 840,
            'cbr_id' => 'R01235',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('exchange_rates')->insert([
        'valute_id' => 1,
        'value' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('exchange_rates')->insert([
            'valute_id' => 2,
            'value' => 62.9006,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
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
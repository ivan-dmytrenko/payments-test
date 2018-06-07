<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('country');

        $countries = [
            ['name' => 'Russia'],
            ['name' => 'Cyprus'],
            ['name' => 'Ukraine'],
            ['name' => 'Germany'],
        ];

        DB::table('country')->insert($countries);
        $this->enableForeignKeys();
    }
}

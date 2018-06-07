<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
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
        $this->truncate('city');

        $cities = [
            ['name' => 'Moscow'],
            ['name' => 'Limassol'],
            ['name' => 'Kyiv'],
            ['name' => 'Krakow'],
        ];

        DB::table('city')->insert($cities);
        $this->enableForeignKeys();
    }
}

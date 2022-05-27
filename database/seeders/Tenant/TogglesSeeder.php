<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;

class TogglesSeeder extends Seeder
{
    public function run()
    {
        \DB::table('toggles')->insert([
            'id' => 1,
            'key' => 'test',
            'value' => 1,
            'group' => NULL
        ]);
    }
}

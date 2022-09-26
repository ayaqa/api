<?php

namespace Database\Seeders\Tenant;

use AyaQA\Enum\SectionId;
use AyaQA\Models\Playground\Toggle;
use Illuminate\Database\Seeder;

class TogglesSeeder extends Seeder
{
    public function run()
    {
        \DB::table(Toggle::TABLE_NAME)->insert([
            'id' => 1,
            'key' => SectionId::TOGGLE_01,
            'value' => 1,
            'group' => NULL
        ]);
    }
}

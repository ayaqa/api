<?php

namespace Database\Seeders\Tenant;

use AyaQA\Enum\SectionId;
use AyaQA\Models\Playground\Checkbox;
use Illuminate\Database\Seeder;

class CheckboxesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'key' => SectionId::CHECKBOX_01,
                'value' => 0,
                'group' => NULL
            ],
            [
                'id' => 2,
                'key' => '2g',
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 3,
                'key' => '3g',
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 4,
                'key' => '4g',
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 5,
                'key' => '5g',
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
        ];

        foreach ($data as $row) {
            \DB::table(Checkbox::TABLE_NAME)->insert($row);
        }
    }
}

<?php

namespace Database\Seeders\Tenant;

use AyaQA\Data\DataTransferObject\Playground\Checkbox\RemindersDTO;
use AyaQA\Data\DataTransferObject\Playground\Checkbox\TechnologiesDTO;
use AyaQA\Enum\SectionId;
use AyaQA\Models\Playground\Checkbox;
use Illuminate\Database\Seeder;

class CheckboxesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // SectionId::CHECKBOX_01
            [
                'id' => 1,
                'key' => SectionId::CHECKBOX_01,
                'value' => 0,
                'group' => NULL
            ],

            // SectionId::CHECKBOX_02
            [
                'id' => 2,
                'key' => TechnologiesDTO::RADIO_2G,
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 3,
                'key' => TechnologiesDTO::RADIO_3G,
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 4,
                'key' => TechnologiesDTO::RADIO_4G,
                'value' => 1,
                'group' => SectionId::CHECKBOX_02
            ],
            [
                'id' => 5,
                'key' => TechnologiesDTO::RADIO_5G,
                'value' => 0,
                'group' => SectionId::CHECKBOX_02
            ],

            // SectionId::CHECKBOX_03
            [
                'id' => 6,
                'key' => SectionId::CHECKBOX_03,
                'value' => 0,
                'group' => NULL
            ],
            [
                'id' => 7,
                'key' => RemindersDTO::CHANNEL_EMAIL,
                'value' => 0,
                'group' => SectionId::CHECKBOX_03
            ],
            [
                'id' => 8,
                'key' => RemindersDTO::CHANNEL_SMS,
                'value' => 0,
                'group' => SectionId::CHECKBOX_03
            ],
            [
                'id' => 9,
                'key' => RemindersDTO::CHANNEL_APP,
                'value' => 0,
                'group' => SectionId::CHECKBOX_03
            ],
        ];

        foreach ($data as $row) {
            \DB::table(Checkbox::TABLE_NAME)->insert($row);
        }
    }
}

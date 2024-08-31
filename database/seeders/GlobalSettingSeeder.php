<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['category', 'product_filter','payment_method'];

        $setting = [
            'category' => [
                'category_design' => '1',
                'options' => [
                    '0' => 'round',
                    '1' => 'square',

                ],
            ],
            'product_filter' => [
                'filter_option' => '1',
                'options' => [
                    '0' => 'fixed',
                    '1' => 'dynamic',
                ],
            ],
            'payment_method' => [
                'stripe' => '1',
                'options' => [
                    '0' => 'disable',
                    '1' => 'enable',
                ],
            ],
            // 'payment_method' => [
            //     'paypal' => '1',
            //     'options' => [
            //         '0' => 'enable',
            //         '1' => 'disable',
            //     ],
            // ],
            'file_system' => [
                'file_system' => '0',
                'options' => [
                    '0' => 'Local',
                    '1' => 'AWS S3',
                ],
            ],
        ];

        foreach ($types as $type) {
            foreach ($setting[$type] as $key => $value) {
                // Skip the 'options' key as it is handled separately
                if ($key === 'options') {
                    continue;
                }

                \App\Models\GlobalSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'options' => json_encode($setting[$type]['options']),
                    'type' => $type,
                    'description' => textCapitalize($key) . ' setting',
                ]);
            }
        }
    }
}

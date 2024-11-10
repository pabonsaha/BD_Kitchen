<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new GeneralSetting();
        $setting->site_name         = "BD Kitchen";
        $setting->site_title        = 'BD Kitchen Website';
        $setting->copyright_text    = '&copy; 2024 <strong>BD Kitchen</strong>, All Rights Reserved. Developed by <a target="_blank" href="">Emon Arefin & Sukonna</a>';
        $setting->save();
    }
}

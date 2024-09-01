<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BlogCategory;
use App\Models\DesignerContact;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use App\Models\BackgroundSetting;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\FileSystemSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\CountryIconSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            GeneralSettingSeeder::class,
            TimeZoneSeeder::class,
            CurrenciesSeeder::class,
            DateFormatSeeder::class,
            ShopSettingSeeder::class,
            CategorySeeder::class,
            
        ]);
    }
}

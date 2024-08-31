<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i<10; $i++){
            $contactUs = new ContactUs();
            $contactUs->first_name = $faker->firstName();
            $contactUs->last_name = $faker->lastName();
            $contactUs->email = $faker->email();
            $contactUs->phone = $faker->phoneNumber();
            $contactUs->message = $faker->text();
            $contactUs->designer_id = 2;
            $contactUs->user_id = 1;
            $contactUs->save();
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123'),
                'biography' => $faker->sentence,
                'gender' => $faker->randomElement(['man', 'woman', 'others']),
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'phone_number' => $faker->numerify('##########'),
                'zip_code' => $faker->postcode,
                'number' => $faker->buildingNumber,
                'street' => $faker->streetName,
                'neighborhood' => $faker->word,
                'city' => $faker->city,
                'state' => $faker->state,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

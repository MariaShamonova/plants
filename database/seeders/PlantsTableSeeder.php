<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plants;

class PlantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plants::truncate();

        $faker = \Faker\Factory::create();

        // А теперь давайте создадим 50 статей в нашей таблице
        for ($i = 0; $i < 50; $i++) {
            Plants::create([
                'articul' => $faker->randomNumber($nbDigits = 6),
                'title' => $faker->name,
                'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000), // 48.8932
                'size_id' => $faker->numberBetween($min = 1, $max = 3),
                'color_id' => $faker->numberBetween($min = 1, $max = 5),
                'category_id' => $faker->numberBetween($min = 1, $max = 10),
                'description' =>  $faker->text(50),
                'image' => $faker->imageUrl(),
            ]);
        }
    }
}

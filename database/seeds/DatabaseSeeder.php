<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\kurikulum_mapel as mapel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
     public function run()
     {
       $faker = Faker::create('id_ID');
       $mapel_id = mapel::max('mapel_id')+1;
       for($i = 1; $i <= 1500; $i++){
         mapel::insert([
           'nama' => $faker->name,
           'mapel_id' => $mapel_id++,
           'kategori_id' => $faker->numberBetween(1,2),
           'created_at' => now(),
           'updated_at' => now(),
         ]);
       }
     }
}

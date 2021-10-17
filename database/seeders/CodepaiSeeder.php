<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CodepaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('codepais')->insert([
            [
                'code' => 'us',
                'number' => 1,
				'name'=>'United States',
            ],
            [
                'code' => 'at',
                'number' => 61,
				'name'=>'Austria',
            ],
            [
                'code' => 'es',
                'number' => 34,
				'name'=> 'Spain',
            ],
            [
                'code' => 'br',
                'number' => 55,
				'name'=> 'Brazil',
            ],
            [
                'code' => 'ca',
                'number' => 1,
				'name'=> 'Canada',
            ],
			 [
                'code' => 'uy',
                'number' => 598,
				'name'=> 'Uruguay',
            ],
			[
                'code' => 'ar',
                'number' => 54,
				'name'=> 'Argentina',
            ],
			[
                'code' => 'de',
                'number' => 49,
				'name'=> 'Germany',
            ],
			[
                'code' => 'fr',
                'number' => 33,
				'name'=> 'France',
            ],
			[
                'code' => 'vi',
                'number' => 1,
				'name'=> 'Dominican Republic &amp; Virgin Islands, US',
            ],
			 [
                'code' => 'co',
                'number' => 57,
				'name'=> 'Colombia',
            ],
        ]);
    }
}

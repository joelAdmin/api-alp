<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('typeusers')->insert([
            [ 
                 'name'       => 'Administrador',
                 'description' => '....',         
             ],

             [ 
                'name'       => 'Tarotista',
                'description' => '.....',         
            ],

            [ 
                'name'       => 'Cliente',
                'description' => '.....',          
            ],
			
			[ 
                'name'       => 'Master',
                'description' => '.....',          
            ],
         ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companys')->insert([
            [ 
                'name'         => 'chat tarot',
                'logo'         => '/storage/img/app/angeologia.com/logo.png',
                'habeasdata'   => '.......',
                'document_id'  => null,
                'document'     => '',
  				'email'        => 'empresa1@astro.com',
                'phone'        => '',
				'web'      	   => 'https://angeologia.com',
				'direction'    => 'DANUBIO AZUL CALLE #56 SUR',
				'status'       => 1,
             ],
         ]);
    }
}

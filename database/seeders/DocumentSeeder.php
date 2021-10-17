<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('documents')->insert([
            [
                'name' => 'Cédula de Ciudadanía',
                'reduction' => 'CC',
            ],
            [
                'name' => 'Cédula de Extranjería',
                'reduction' => 'CE',
            ],
            [
                'name' => 'Tarjeta de Identidad',
                'reduction' => 'TI',
            ],
            [
                'name' => 'NIT',
                'reduction' => 'NIT',
            ],
            [
                'name' => 'Pasaporte',
                'reduction' => 'PP',
            ],
            [
                'name' => 'Permiso Especial de permanencia',
                'reduction' => 'PEP',
            ],
        ]);
    }
}

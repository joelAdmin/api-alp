<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
			[ 
                #'ducument_id' => null,
                'document'    => '123456',
                'typeuser_id' => 1,
                'name'        => 'master',
                'lastname'    => null,
                'email'       =>'master@gmail.com',
                'fechanac'    => null,
                'genero'      => null,
                'avatar'      => '/storage/img/user/avatar-2.jpg',
                'codepai_id'  => 1,
                'phone'       => '3105523663',
                'company_id'  => 1, 
                'codesms'     => '0378',
                'confirmsms'  => 1,
                'connected'   => 0,
                'status'      => 1,
                'password'    => \Hash::make('123456'),          
                'remember_token' => \Str::random(10)      
            ],
            [ 
                #'ducument_id' => null,
                'document'    => '123456',
                'typeuser_id' => 1,
                'name'        => 'user_1',
                'lastname'    => null,
                'email'       =>'user_1@gmail.com',
                'fechanac'    => null,
                'genero'      => null,
                'avatar'      => '/storage/img/user/avatar-2.jpg',
                'codepai_id'  => 1,
                'phone'       => '3105523663',
                'company_id'  => 1, 
                'codesms'     => '0378',
                'confirmsms'  => 1,
                'connected'   => 0,
                'status'      => 1,
                'password'    => \Hash::make('123456'),          
                'remember_token' => \Str::random(10)      
            ],
            [ 
                #'ducument_id' => null,
                'document'    => '123456',
                'typeuser_id' => 1,
                'name'        => 'user_2',
                'lastname'    => null,
                'email'       =>'user_2@gmail.com',
                'fechanac'    => null,
                'genero'      => null,
                'avatar'      => '/storage/img/user/avatar-2.jpg',
                'codepai_id'  => 1,
                'phone'       => '3105523663',
                'company_id'  => 1, 
                'codesms'     => '0378',
                'confirmsms'  => 1,
                'connected'   => 0,
                'status'      => 1,
                'password'    => \Hash::make('123456'),          
                'remember_token' => \Str::random(10)      
            ],
            [ 
                #'ducument_id' => null,
                'document'    => '123456',
                'typeuser_id' => 1,
                'name'        => 'user_3',
                'lastname'    => null,
                'email'       =>'user_3@gmail.com',
                'fechanac'    => null,
                'genero'      => null,
                'avatar'      => '/storage/img/user/avatar-2.jpg',
                'codepai_id'  => 1,
                'phone'       => '3105523663',
                'company_id'  => 1, 
                'codesms'     => '0378',
                'confirmsms'  => 1,
                'connected'   => 0,
                'status'      => 1,
                'password'    => \Hash::make('123456'),          
                'remember_token' => \Str::random(10)      
            ],
            [ 
                #'ducument_id' => null,
                'document'    => '123456',
                'typeuser_id' => 1,
                'name'        => 'user_4',
                'lastname'    => null,
                'email'       =>'user_4@gmail.com',
                'fechanac'    => null,
                'genero'      => null,
                'avatar'      => '/storage/img/user/avatar-2.jpg',
                'codepai_id'  => 1,
                'phone'       => '3105523663',
                'company_id'  => 1, 
                'codesms'     => '0378',
                'confirmsms'  => 1,
                'connected'   => 0,
                'status'      => 1,
                'password'    => \Hash::make('123456'),          
                'remember_token' => \Str::random(10)      
            ]
        ]);
    }
}

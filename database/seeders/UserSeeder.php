<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'           => 'Untara',
                'institution_id' => null,
                'email'          => 'untara@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 1,
            ],
            [
                'name'           => 'dr. Taufik',
                'institution_id' => null,
                'email'          => 'dr.taufik@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 1,
            ],
            [
                'name'           => 'dr. Tinanda',
                'institution_id' => null,
                'email'          => 'tinanda@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 1,
            ],
            [
                'name'           => 'dr. Novia',
                'institution_id' => null,
                'email'          => 'dr.novia@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 2,
            ],
            [
                'name'           => 'dr. Suci',
                'institution_id' => null,
                'email'          => 'dr.suci@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 2,
            ],
            [
                'name'           => 'dr. Hafiedz',
                'institution_id' => null,
                'email'          => 'dr.hafiedz@vascular-registry.id',
                'password'       => Hash::make('vascular'),
                'role_id'        => 2,
            ],
        ];

        foreach ($data as $datum){
            try{
                DB::table('users')->insert($datum);
            }catch (\Exception $e){}
        }
    }
}

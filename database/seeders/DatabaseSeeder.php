<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\bagian;
use App\Models\bagian_baju;
use App\Models\Material;
use App\Models\Person;
use App\Models\PersonProcess;
use App\Models\process_type;
use App\Models\production_process_type;
use App\Models\production_type;
use App\Models\ukuran;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Material::create([
            'material_name' => 'Fabric',
            'material_description' => 'Fabric is a material made of a network of natural or artificial fibres',
            'material_quantity' => 20,
            'material_measure_unit' => 'm',
            'material_type'=>'Raw Material',
        ]);

        Material::create([
            'material_name' => 'Thread',
            'material_description' => 'Thread is a type of yarn used for sewing by hand or machine',
            'material_quantity' => 100,
            'material_measure_unit' => 'm',
            'material_type'=>'Raw Material',
        ]);

        $ukuran=[
            'S',
            'M',
            'L',
            'XL',
            'XXL',
        ];
        $bagian=[
            'Lengan Kanan',
            'Lengan Kiri',
            'Badan Depan',
            'Badan Belakang',
            'Baju Jadi'
        ];
        foreach ($ukuran as $key => $value) {
            ukuran::create([
                'name' => $value,
            ]);
        }

        foreach ($bagian as $key => $value) {
            bagian::create([
                'name' => $value,
            ]);
        }

        
        $processType=[
            'Production',
            'Potong',
            'Jahit',
            'Obras',
            'Finishing',
        ];

        foreach ($processType as $item) {
            process_type::create([
                'process_type_name' => $item,
            ]);
        }
        production_type::create([
            'production_type_name' => 'Atasan',
        ]);

        production_type::create([
            'production_type_name' => 'Bawahan',
        ]);

        production_process_type::create([
            'production_type_id' => 1,
            'process_type_id' => 1,
        ]);

        production_process_type::create([
            'production_type_id' => 1,
            'process_type_id' => 2,
        ]);

        production_process_type::create([
            'production_type_id' => 1,
            'process_type_id' => 3,
        ]);

        production_process_type::create([
            'production_type_id' => 1,
            'process_type_id' => 5,
        ]);

        production_process_type::create([
            'production_type_id' => 2,
            'process_type_id' => 1,
        ]);

        production_process_type::create([
            'production_type_id' => 2,
            'process_type_id' => 2,
        ]);

        production_process_type::create([
            'production_type_id' => 2,
            'process_type_id' => 3,
        ]);

        production_process_type::create([
            'production_type_id' => 2,
            'process_type_id' => 4,
        ]);

        production_process_type::create([
            'production_type_id' => 2,
            'process_type_id' => 5,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'random@gmail.com',  
            'password' => bcrypt('123'),
        ]);

        User::create([
            'name' => 'Raka',
            'email' => 'Raka@gmail.com',
            'password' => bcrypt('123'),
        ]);

        User::create([
            'name' => 'Rizki',
            'email' => 'Rizki@gmail.com',
            'password' => bcrypt('123'),
        ]);

        PersonProcess::create([
            'user_id' => 2,
            'process_type_id' => 1,
        ]);


        PersonProcess::create([
            'user_id' => 3,
            'process_type_id' => 2,
        ]);

        PersonProcess::create([
            'user_id' => 2,
            'process_type_id' => 3,
        ]);
        
        PersonProcess::create([
            'user_id' => 3,
            'process_type_id' => 4,
        ]);

        PersonProcess::create([
            'user_id' => 2,
            'process_type_id' => 5,
        ]);








    }
}

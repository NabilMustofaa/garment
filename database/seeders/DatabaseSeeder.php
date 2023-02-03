<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\bagian;
use App\Models\bagian_baju;
use App\Models\colour;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialHistory;
use App\Models\MaterialSubCategory;
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

        MaterialCategory::create([
            'category_name' => 'Kain',
        ]);
        MaterialCategory::create([
            'category_name' => 'Benang',
        ]);
        MaterialCategory::create([
            'category_name' => 'Aksesoris',
        ]);
        MaterialCategory::create([
            'id'=>998,
            'category_name' => 'Produk',
        ]);
        MaterialCategory::create([
            'id'=>999,
            'category_name' => 'Semi Finished Goods',
        ]);
        
        // MaterialSubCategory::create([
        //     'id'=>998,
        //     'sub_category_name' => 'Produk',
        //     'material_category_id' => 998,
        // ]);
        
        MaterialSubCategory::create([
            'sub_category_name' => 'Kain Katun',
            'material_category_id' => 1,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Kain Sutra',
            'material_category_id' => 1,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Kain Silk',
            'material_category_id' => 1,
        ]);

        MaterialSubCategory::create([
            'sub_category_name' => 'Benang',
            'material_category_id' => 2,
        ]);

        MaterialSubCategory::create([
            'sub_category_name' => 'Kancing',
            'material_category_id' => 3,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Resleting',
            'material_category_id' => 3,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Pita',
            'material_category_id' => 3,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Renda',
            'material_category_id' => 3,
        ]);
        MaterialSubCategory::create([
            'sub_category_name' => 'Manik-manik',
            'material_category_id' => 3,
        ]);

        MaterialSubCategory::create([
            'id'=>999,
            'sub_category_name' => 'Semi Finished Goods',
            'material_category_id' => 999,
        ]);

        Material::create([
            'material_name' => 'Kain Katun',
            'bagian_baju_id' => NULL,
            'material_description' => 'Kain Katun',
            'material_quantity' => 100,
            'material_measure_unit' => 'Meter',
            'material_sub_category_id' => 1,
        ]);

        Material::create([
            'material_name' => 'Benang',
            'bagian_baju_id' => NULL,
            'material_description' => 'Benang',
            'material_quantity' => 100,
            'material_measure_unit' => 'Meter',
            'material_sub_category_id' => 4,
        ]);

        Material::create([
            'material_name' => 'Kancing',
            'bagian_baju_id' => NULL,
            'material_description' => 'Kancing',
            'material_quantity' => 100,
            'material_measure_unit' => 'Meter',
            'material_sub_category_id' => 5,
        ]);

        Material::create([
            'material_name' => 'Resleting',
            'bagian_baju_id' => NULL,
            'material_description' => 'Resleting',
            'material_quantity' => 100,
            'material_measure_unit' => 'Meter',
            'material_sub_category_id' => 6,
        ]);

        Material::create([
            'material_name' => 'Pita',
            'bagian_baju_id' => NULL,
            'material_description' => 'Pita',
            'material_quantity' => 100,
            'material_measure_unit' => 'Meter',
            'material_sub_category_id' => 7,
        ]);

        MaterialHistory::create([
            'material_id' => 1,
            'quantity' => 100,
            'description' => 'Initial Stock',
        ]);

        MaterialHistory::create([
            'material_id' => 2,
            'quantity' => 100,
            'description' => 'Initial Stock',
        ]);

        MaterialHistory::create([
            'material_id' => 3,
            'quantity' => 100,
            'description' => 'Initial Stock',
        ]);

        MaterialHistory::create([
            'material_id' => 4,
            'quantity' => 100,
            'description' => 'Initial Stock',
        ]);

        MaterialHistory::create([
            'material_id' => 5,
            'quantity' => 100,
            'description' => 'Initial Stock',
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
            'Baju'
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
            'Setrika',
            'Finishing',
            'Payet',
            'Permak'
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
            'user_id' => 2,
            'process_type_id' => 7,
        ]);

        PersonProcess::create([
            'user_id' => 3,
            'process_type_id' => 2,
        ]);

        PersonProcess::create([
            'user_id' => 3,
            'process_type_id' => 7,
        ]);


        // //read csv
        // $colourcsv = array_map('str_getcsv', file('database/seeders/color_names.csv'));
        // $colourcsv = array_slice($colourcsv, 1);
        // foreach ($colourcsv as $key => $value) {
        //     $color = new colour();
        //     $color->colour_name = $value[0];
        //     $color->colour_code = $value[1];
        //     $color->save();
        // }
        







    }
}

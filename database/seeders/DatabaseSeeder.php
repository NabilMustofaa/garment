<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Material;
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
            'material_type'=>'Raw Material',
        ]);

        Material::create([
            'material_name' => 'Thread',
            'material_description' => 'Thread is a type of yarn used for sewing by hand or machine',
            'material_type'=>'Raw Material',
        ]);
    }
}

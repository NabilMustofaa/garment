<?php

namespace Database\Seeders;

use App\Models\process_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tambahType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        process_type::create([
            'process_type_name' => 'Kirim Ke Toko',
        ]);
    }
}

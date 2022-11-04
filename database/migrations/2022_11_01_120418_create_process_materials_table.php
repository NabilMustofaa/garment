<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id');
            $table->foreignId('material_id');
            $table->string('process_material_name')->nullable();
            $table->integer('process_material_quantity');
            $table->string('process_material_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_materials');
    }
};

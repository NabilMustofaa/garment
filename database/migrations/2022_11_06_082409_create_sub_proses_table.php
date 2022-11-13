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
        Schema::create('sub_proses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id');
            $table->foreignId('process_material_id');
            $table->foreignId('user_id');
            $table->string('sub_proses_name');
            $table->integer('sub_proses_projected');
            $table->integer('sub_proses_actual');
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
        Schema::dropIfExists('sub_proses');
    }
};

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
        Schema::create('production_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('production_id');
            $table->foreignId('process_id');
            $table->integer('production_process_input_quantity');
            $table->integer('production_process_output_quantity');
            $table->string('production_process_status');
            $table->dateTime('production_process_start_date');
            $table->dateTime('production_process_end_date')->nullable();
            $table->text('production_process_message')->nullable();
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
        Schema::dropIfExists('production_processes');
    }
};

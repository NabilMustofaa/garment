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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('production_name');
            $table->text('production_description');
            $table->string('production_status');
            $table->date('production_projected_end_date');
            $table->date('production_actual_end_date')->nullable();
            $table->integer('production_input_quantity');
            $table->foreignId('production_material_id');
            $table->integer('production_output_quantity');
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
        Schema::dropIfExists('productions');
    }
};

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
        Schema::create('bagian_bajus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bagian_id')->constrained('bagians')->onDelete('cascade');
            $table->foreignId('ukuran_id')->constrained('ukurans')->onDelete('cascade');
            $table->foreignId('production_id')->constrained('productions')->onDelete('cascade');
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
        Schema::dropIfExists('bagian_bajus');
    }
};

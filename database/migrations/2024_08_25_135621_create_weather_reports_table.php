<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weather_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained();
            $table->integer('timezone');           
            $table->float('temperature');
            $table->float('feels_like');
            $table->float('temp_min');
            $table->float('temp_max');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->integer('visibility');
            $table->timestamp('timestamp');
            $table->timestamp('sunrise');
            $table->timestamp('sunset');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_reports');
    }
};
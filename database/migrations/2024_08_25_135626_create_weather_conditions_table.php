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
        Schema::create('weather_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('weather_reports');
            $table->integer('condition_id');
            $table->string('main');
            $table->string('description');
            $table->string('icon');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_conditions');
    }
};

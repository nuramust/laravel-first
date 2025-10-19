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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentist_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('day_of_week')->comment('0 = Sunday, 1 = Monday, ..., 6 = Saturday');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            // Ensure no duplicate schedule for same dentist + day
            $table->unique(['dentist_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
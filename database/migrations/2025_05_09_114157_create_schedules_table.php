<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();                               // Primary key
            $table->unsignedBigInteger('user_id');      // Foreign key to `users` table
            $table->string('monday');                  // Time for Monday
            $table->string('tuesday');                 // Time for Tuesday
            $table->string('wednesday');               // Time for Wednesday
            $table->string('thursday');                // Time for Thursday
            $table->string('friday');                  // Time for Friday
            $table->date('startOfWeek');               // Start date of the week
            $table->date('endOfWeek');                 // End date of the week
            $table->timestamps();                      // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};

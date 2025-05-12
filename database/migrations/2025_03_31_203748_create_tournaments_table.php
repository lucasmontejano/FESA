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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('game');  // Added for game type (CS:GO, LoL, etc.)
            $table->text('description')->nullable();
            $table->date('start_date');  // Added for tournament start
            $table->date('end_date');    // Added for tournament end
            $table->integer('max_participants');
            $table->integer('participants_count')->default(0);  // Added for tracking
            $table->string('banner')->nullable();  // Added for image path storage
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Optional: Add index for better performance
            $table->index('start_date');
            $table->index('game');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
};
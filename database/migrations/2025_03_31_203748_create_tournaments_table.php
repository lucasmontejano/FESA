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
            $table->text('description')->nullable();
            $table->integer('max_participants');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link creator
            $table->timestamps();
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

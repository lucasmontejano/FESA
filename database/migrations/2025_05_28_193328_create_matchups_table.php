<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matchups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            $table->integer('match_in_round')->nullable(); // For ordering within a round
            $table->foreignId('team1_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('team2_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('winner_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->integer('team1_score')->nullable();
            $table->integer('team2_score')->nullable();
            $table->string('status')->default('pending'); // pending, live, team1_won, team2_won, completed, disputed
            $table->timestamp('scheduled_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchups');
    }
};

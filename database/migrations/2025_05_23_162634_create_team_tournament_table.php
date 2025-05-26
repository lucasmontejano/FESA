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
        Schema::create('team_tournament', function (Blueprint $table) {
            $table->id(); // Ou use chaves primárias compostas se preferir
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            // Você pode adicionar outras colunas aqui se necessário (ex: status da inscrição, data de inscrição)
            $table->timestamps(); // Opcional, mas útil

            // Para garantir que uma equipe só possa se inscrever uma vez em um torneio
            $table->unique(['team_id', 'tournament_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_tournament');
    }
};
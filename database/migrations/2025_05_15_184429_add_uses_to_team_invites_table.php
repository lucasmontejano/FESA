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
        Schema::table('team_invites', function (Blueprint $table) {
            Schema::table('team_invites', function (Blueprint $table) {
            $table->integer('max_uses')->nullable()->after('expires_at');
            $table->integer('uses')->default(0)->after('max_uses');
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_invites', function (Blueprint $table) {
            $table->dropColumn('max_uses');
            $table->dropColumn('uses');
        });
    }
};

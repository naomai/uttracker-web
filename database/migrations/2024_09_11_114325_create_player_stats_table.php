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
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId("player_id")->constrained();
            $table->foreignId("server_id")->constrained();
            $table->integer("game_time")->default('0');
            $table->bigInteger("score")->default('0');
            $table->integer("deaths")->default('0');
            $table->foreignId("last_match_id")->constrained('server_matches');;
            $table->unique(['player_id', 'server_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};

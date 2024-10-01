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
        Schema::create('player_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("player_id")->constrained();
            $table->foreignId("server_id")->constrained();
            $table->foreignId("match_id")->constrained('server_matches');
            $table->integer("seen_count")->default("0");
            $table->timestamp("last_seen_time")->useCurrent();
            $table->timestamp("first_seen_time")->useCurrent();
            $table->bigInteger("score_this_match")->default("0");
            $table->integer("deaths_this_match")->nullable();
            $table->integer("ping_sum")->default("0");
            $table->integer("team")->default("0");
            $table->boolean("finished")->default("0");
            $table->index("finished");
            $table->unique(['player_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_logs');
    }
};

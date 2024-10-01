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
        Schema::create('server_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId("server_id")->constrained();
            $table->timestamp("start_time");
            $table->string("map_name");
            $table->integer("server_playerid_counter")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_matches');
    }
};

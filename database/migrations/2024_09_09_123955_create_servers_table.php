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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string("address", 60)->unique();
            $table->string("name");
            $table->json("variables")->default("{}");
            $table->timestamp("last_check")->nullable();
            $table->timestamp("last_success")->nullable();
            $table->timestamp("last_validation")->nullable();
            $table->timestamp("last_rating_calculation")->nullable();
            $table->integer("rating_month")->default('0');
            $table->integer("rating_minute")->default('0');
            $table->string("country", 3)->nullable();
            $table->string("game_name");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};

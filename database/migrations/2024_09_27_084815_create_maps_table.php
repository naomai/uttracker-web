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
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->string("map_name")->unique();
            $table->string("author");
            $table->string("download_url");
            $table->json("report");
            $table->integer("bound_size_x");
            $table->integer("bound_size_y");
            $table->integer("bound_size_z");
            $table->integer("brush_count_additive");
            $table->integer("brush_count_subtractive");
            $table->integer("zone_count");
            $table->integer("light_wattage");
            $table->integer("texture_count");
            $table->integer("class_count");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maps');
    }
};

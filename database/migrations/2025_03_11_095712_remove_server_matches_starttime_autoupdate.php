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
        Schema::table('server_matches', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('server_matches')) {
            Schema::table('server_matches', function (Blueprint $table) {
                if(Schema::hasColumn('server_matches', 'start_time')) {
                    $table->timestamp('start_time')->change();
                }
            });
        }
    }
};

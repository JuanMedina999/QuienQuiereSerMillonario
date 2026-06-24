<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->tinyInteger('fifty_fifty_used')->default(0);
            $table->tinyInteger('fifty_fifty_limit')->default(2);
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('fifty_fifty_used');
            $table->dropColumn('fifty_fifty_limit');
        });
    }
};
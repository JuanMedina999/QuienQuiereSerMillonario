<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('games', function (Blueprint $table) {
        $table->boolean('cambio_pregunta_usado')->default(false);
    });
}

public function down(): void
{
    Schema::table('games', function (Blueprint $table) {
        $table->dropColumn('cambio_pregunta_usado');
    });
}

};

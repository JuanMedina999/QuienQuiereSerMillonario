<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('questions', function (Blueprint $table) {

        if (!Schema::hasColumn('questions', 'points')) {
            $table->integer('points')->default(100)->after('question');
        }

        if (!Schema::hasColumn('questions', 'time_limit')) {
            $table->integer('time_limit')->default(30)->after('points');
        }

    });
}
};

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
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('schedebianche')->nullable()->change();
            $table->integer('schedenulle')->nullable()->change();
            $table->integer('aventidiritto')->nullable()->change();
            $table->integer('m5s')->nullable()->change();
            $table->integer('pd')->nullable()->change();
            $table->integer('azione')->nullable()->change();
            $table->integer('verdisi')->nullable()->change();
            $table->integer('abruzzoinsieme')->nullable()->change();
            $table->integer('damicopresidente')->nullable()->change();
            $table->integer('fdi')->nullable()->change();
            $table->integer('lega')->nullable()->change();
            $table->integer('forzaitalia')->nullable()->change();
            $table->integer('noimoderati')->nullable()->change();
            $table->integer('unionedicentro')->nullable()->change();
            $table->integer('marsiliopresidente')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            //
        });
    }
};

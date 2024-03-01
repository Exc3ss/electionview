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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('numero');
            $table->integer('schedebianche');
            $table->integer('schedenulle');
            $table->integer('aventidiritto');
            $table->integer('votanti');
            $table->integer('damico');
            $table->integer('m5s');
            $table->integer('pd');
            $table->integer('azione');
            $table->integer('verdisi');
            $table->integer('abruzzoinsieme');
            $table->integer('damicopresidente');
            $table->integer('marsilio');
            $table->integer('fdi');
            $table->integer('lega');
            $table->integer('forzaitalia');
            $table->integer('noimoderati');
            $table->integer('unionedicentro');
            $table->integer('marsiliopresidente');
            $table->timestamps();

            $table->foreignId('comune_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('provincia_id')->constrained('provinces');
            $table->unique(['numero', 'comune_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('sections', function (Blueprint $table) {
           $table->dropForeign(['comune_id']);
           $table->dropForeign(['provincia_id']);
        });
        Schema::dropIfExists('sections');

    }
};

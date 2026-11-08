<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('np', function (Blueprint $table) {
            $table->id();
            $table->string('nev');
        });

        Schema::create('telepules', function (Blueprint $table) {
            $table->id();
            $table->string('nev');
            $table->foreignId('npid')->constrained('np')->restrictOnDelete();
        });

        Schema::create('ut', function (Blueprint $table) {
            $table->id('azon');
            $table->string('nev');
            $table->decimal('hossz', 8, 2);
            $table->unsignedSmallInteger('allomas');
            $table->decimal('ido', 6, 2);
            $table->boolean('vezetes');
            $table->foreignId('telepulesid')->constrained('telepules')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ut');
        Schema::dropIfExists('telepules');
        Schema::dropIfExists('np');
    }
};
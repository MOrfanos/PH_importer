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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pornstar_id')->constrained()->onDelete('cascade');
            $table->string('hairColor')->nullable();
            $table->string('ethnicity')->nullable();
            $table->boolean('tattoos');
            $table->boolean('piercings');
            $table->integer('breastSize')->nullable();
            $table->string('breastType')->nullable();
            $table->string('gender');
            $table->string('orientation');
            $table->integer('age')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};

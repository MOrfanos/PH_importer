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
        Schema::create('pornstars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license');
            $table->tinyInteger('wlStatus');
            $table->string('link');
            $table->json('aliases')->nullable();
            $table->string('hash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pornstars');
    }
};

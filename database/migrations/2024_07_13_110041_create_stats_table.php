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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pornstar_id')->constrained()->onDelete('cascade');
            $table->integer('subscriptions');
            $table->integer('monthlySearches');
            $table->integer('views');
            $table->integer('videosCount');
            $table->integer('premiumVideosCount');
            $table->integer('whiteLabelVideoCount');
            $table->integer('rank');
            $table->integer('rankPremium');
            $table->integer('rankWl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};

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
            $table->string('type'); // projects, faq, blog, cta, why_botjourney, industries, how_it_works, hero
            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('badge')->nullable();
            $table->json('button_text')->nullable();
            $table->string('button_direction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

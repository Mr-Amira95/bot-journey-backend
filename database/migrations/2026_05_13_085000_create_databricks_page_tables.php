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
        Schema::create('databricks_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });

        Schema::create('databricks_services', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('databricks_use_cases', function (Blueprint $table) {
            $table->id();
            $table->json('industry')->nullable();
            $table->json('headline')->nullable();
            $table->json('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('databricks_stats', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->json('label')->nullable();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databricks_stats');
        Schema::dropIfExists('databricks_use_cases');
        Schema::dropIfExists('databricks_services');
        Schema::dropIfExists('databricks_sections');
    }
};

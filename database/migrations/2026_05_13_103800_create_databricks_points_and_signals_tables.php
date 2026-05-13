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
        Schema::create('databricks_partner_points', function (Blueprint $table) {
            $table->id();
            $table->json('text')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('databricks_trust_signals', function (Blueprint $table) {
            $table->id();
            $table->json('text')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databricks_trust_signals');
        Schema::dropIfExists('databricks_partner_points');
    }
};

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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');
            $table->unsignedTinyInteger('layout_id')->default(0);
            $table->string('parent_id', 10)->nullable();
            $table->unsignedInteger('ordering_id');
            $table->string('name');
            $table->string('region', 10)->default('ALL');
            $table->timestamps();

            $table->index('parent_id');
            $table->index('ordering_id');
            $table->index('region');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

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
        Schema::create('server_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id')->unique();
            $table->integer('online_users')->default(0);
            $table->integer('wait_users')->default(0);
            $table->integer('lobby_users')->default(0);
            $table->integer('status')->default(0);
            $table->integer('congestion')->default(0);
            $table->json('channel_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_statuses');
    }
};

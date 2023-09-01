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
        Schema::create('crawlees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('screenshot_path')->nullable();
            $table->json('contents');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawlees');
    }
};

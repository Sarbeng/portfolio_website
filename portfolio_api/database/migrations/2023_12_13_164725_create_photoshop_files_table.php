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
        Schema::create('photoshop_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('description')->nullable();
            $table->string('file_location');
            $table->integer('youtube_id')->unsigned()->nullable();
            $table->foreign('youtube_id')->references('id')->on('youtube_files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photoshop_files');
    }
};

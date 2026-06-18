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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('title')->nullable();
            $table->string('department')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->string('image')->nullable();
            $table->string('experience')->nullable();
            $table->unsignedInteger('reviews')->nullable();
            $table->enum('type', ['consultant', 'outdoor'])->default('consultant');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

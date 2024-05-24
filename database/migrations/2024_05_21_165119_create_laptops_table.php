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
        Schema::create('manufactories', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                  ->unique();
            $table->string('descripton')
                  ->nullable();
            $table->timestamps('started_at');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                  ->unique();
            $table->string('description')
                  ->nullable();
        });
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnUpdate();
            $table->foreignId('manufactory_id')
                  ->constrained()
                  ->cascadeOnUpdate();
            $table->timestamps('create_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
        Schema::dropIfExists('manufactories');
        Schema::dropIfExists('categories');
    }
};

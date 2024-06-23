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
            $table->string('description')
                  ->nullable();
            $table->timestamp('started_at')
                  ->nullable();
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                  ->unique();
            $table->string('description')
                  ->nullable();
            $table->timestamps();
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
            // $table->string('CPU');
            // $table->string('VGA');
            // $table->string('RAM');
            // $table->string('hard_drive');
            // $table->string('display');
            // $table->string('battery');
            // $table->float('weight');
            // $table->string('material');
            // $table->string('OS');
            // $table->string('size');
            // $table->string('ports');
            // $table->string('keyboard');
            // $table->string('audio');
            $table->integer('quantity');
            $table->decimal('price',15,2);
            // $table->string('network_and_connection');
            // $table->string('security')->nullable();
            // $table->string('webcam')->nullable();
            $table->string('status');
            $table->timestamps();
        });
        Schema::create('laptop_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laptop_id')->constrained();
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

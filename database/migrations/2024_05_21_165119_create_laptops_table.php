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
            $table->string('address');
            $table->string('website')
                    ->nullable();
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')
            ->unique();
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
            $table->string('CPU')->nullable();
            $table->string('VGA')->nullable();
            $table->string('RAM')->nullable();
            $table->string('hard_drive')->nullable();
            $table->string('display')->nullable();
            $table->string('battery')->nullable();
            $table->float('weight')->nullable();
            $table->string('material')->nullable();
            $table->string('OS')->nullable();
            $table->string('size')->nullable();
            $table->string('ports')->nullable();
            $table->string('keyboard')->nullable();
            $table->string('audio')->nullable();
            $table->integer('quantity');
            $table->decimal('price',12,0);
            $table->string('network_and_connection')->nullable();
            $table->string('security')->nullable();
            $table->string('webcam')->nullable();
            $table->string('status');
            $table->timestamps();
        });
        Schema::create('laptop_pictures', function (Blueprint $table) {
            $table->id();
            $table->string('path');
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

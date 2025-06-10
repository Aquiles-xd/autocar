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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('status')->default(0);
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('CASCADE');
            $table->string('name');
            $table->double('amount');
            // $table->string('description');
            $table->enum('type', ['Usado', 'Novo']);
            $table->enum('mark', ["Honda",
    "Yamaha",
    "Suzuki",
    "BMW",
    "Toyota",
    "Ford",
    "Chevrolet",
    "Volkswagen",
    "Porsche",
    "Subaru",
    "Audi",
    "Royal Enfield",
    "Triumph",
    "Harley Davidson",
    "Nissan",
    "Renault"]);
            $table->text('location');
            // $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

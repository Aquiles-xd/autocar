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
        Schema::create('searched_plates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('model');
            $table->string('fabricator');
            $table->integer('number_engine');
            $table->string('vehicle_owner');
            $table->string('chassi');
            $table->string('color');
            $table->string('theft_history');
            $table->string('auction');
            $table->integer('renavam');
            $table->string('plate');
            $table->date('year_fab');
            $table->date('year_model');
            $table->string('city');
            $table->integer('value_fipe');
            $table->date('month_fipe');
            $table->integer('debts');

        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

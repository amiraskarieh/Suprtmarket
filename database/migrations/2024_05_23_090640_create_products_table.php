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
            $table->string('name', 50);
            $table->bigInteger('sell_price');
            $table->bigInteger('discount');
            $table->bigInteger('available');
            $table->text('description');
            $table->date('production_date');
            $table->boolean('is_perishable');
            $table->date('perishable_data')->nullable();
            $table->bigInteger('sell_number');
            $table->bigInteger('buy_price');
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

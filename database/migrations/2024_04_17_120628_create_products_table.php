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
            $table->string('sku');
            $table->foreignId('category_id')->constrained('category_products')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->integer('price');
            $table->integer('discount_price')->default(0);
            $table->json('tags');
            $table->foreignId('type_id')->constrained('product_types')->onDelete('cascade');
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

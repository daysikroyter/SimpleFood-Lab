<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('product_reviews', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained()->cascadeOnDelete();
      $table->unsignedBigInteger('user_id'); // Без FK, т.к. users в другой БД

      // было tinyInteger
      $table->decimal('rating', 2, 1)->unsigned(); 

      $table->text('comment');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('product_reviews');
  }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();

      $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

      $table->string('status')->default('pending');

      $table->unsignedInteger('total_price'); 

      $table->string('customer_name');
      $table->string('phone', 50)->nullable();
      $table->string('address')->nullable();

      $table->text('comment')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};

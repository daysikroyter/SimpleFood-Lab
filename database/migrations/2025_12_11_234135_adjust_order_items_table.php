<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (! Schema::hasTable('order_items')) {
      Schema::create('order_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')
          ->constrained()
          ->cascadeOnDelete();

        $table->foreignId('product_id')
          ->constrained()
          ->restrictOnDelete();

        $table->unsignedInteger('price');
        $table->unsignedInteger('quantity');

        $table->timestamps();
      });

      return;
    }

    Schema::table('order_items', function (Blueprint $table) {
      if (! Schema::hasColumn('order_items', 'order_id')) {
        $table->foreignId('order_id')
          ->after('id')
          ->constrained()
          ->cascadeOnDelete();
      }

      if (! Schema::hasColumn('order_items', 'product_id')) {
        $table->foreignId('product_id')
          ->after('order_id')
          ->constrained()
          ->restrictOnDelete();
      }

      if (! Schema::hasColumn('order_items', 'price')) {
        $table->unsignedInteger('price')
          ->after('product_id');
      }

      if (! Schema::hasColumn('order_items', 'quantity')) {
        $table->unsignedInteger('quantity')
          ->after('price');
      }
    });
  }

  public function down(): void
  {
    if (Schema::hasTable('order_items')) {
      Schema::dropIfExists('order_items');
    }
  }
};

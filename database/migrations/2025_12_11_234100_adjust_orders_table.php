<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (! Schema::hasTable('orders')) {
      Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

        $table->unsignedInteger('total_price');

        $table->string('status')->default('new');
        $table->string('payment_method')->nullable();
        $table->string('payment_status')->default('unpaid');

        $table->string('customer_name');
        $table->string('phone', 32);
        $table->string('address', 500);

        $table->json('meta')->nullable();

        $table->timestamps();
      });

      return;
    }

    Schema::table('orders', function (Blueprint $table) {
      if (! Schema::hasColumn('orders', 'user_id')) {
        $table->foreignId('user_id')
          ->after('id')
          ->constrained()
          ->cascadeOnDelete();
      }

      if (! Schema::hasColumn('orders', 'total_price')) {
        $table->unsignedInteger('total_price')
          ->after('user_id');
      }

      if (! Schema::hasColumn('orders', 'status')) {
        $table->string('status')
          ->default('new')
          ->after('total_price');
      }

      if (! Schema::hasColumn('orders', 'payment_method')) {
        $table->string('payment_method')
          ->nullable()
          ->after('status');
      }

      if (! Schema::hasColumn('orders', 'payment_status')) {
        $table->string('payment_status')
          ->default('unpaid')
          ->after('payment_method');
      }

      if (! Schema::hasColumn('orders', 'customer_name')) {
        $table->string('customer_name')
          ->after('payment_status');
      }

      if (! Schema::hasColumn('orders', 'phone')) {
        $table->string('phone', 32)
          ->after('customer_name');
      }

      if (! Schema::hasColumn('orders', 'address')) {
        $table->string('address', 500)
          ->after('phone');
      }

      if (! Schema::hasColumn('orders', 'meta')) {
        $table->json('meta')
          ->nullable()
          ->after('address');
      }
    });
  }

  public function down(): void
  {
    if (Schema::hasTable('orders')) {
      Schema::dropIfExists('orders');
    }
  }
};

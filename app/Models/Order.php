<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'total_price',
    'status',
    'payment_method',
    'payment_status',
    'customer_name',
    'phone',
    'address',
    'meta',
  ];

  protected $casts = [
    'meta' => 'array',
  ];

  public const STATUSES = [
    'new'        => 'Новый',
    'processing' => 'В обработке',
    'completed'  => 'Выполнен',
    'cancelled'  => 'Отменён',
  ];

  public const PAYMENT_STATUSES = [
    'unpaid'   => 'Не оплачен',
    'paid'     => 'Оплачен',
    'failed'   => 'Ошибка оплаты',
    'refunded' => 'Возврат',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function getStatusLabelAttribute(): string
  {
    return self::STATUSES[$this->status] ?? $this->status;
  }

  public function getPaymentStatusLabelAttribute(): string
  {
    return self::PAYMENT_STATUSES[$this->payment_status] ?? $this->payment_status;
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CartItem;

class Product extends Model
{
  protected $fillable = [
    'category_id',
    'title',
    'slug',
    'price',
    'image',
    'description',
    'features',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function reviews(): HasMany
  {
    return $this->hasMany(ProductReview::class);
  }

  public function getAverageRatingAttribute(): ?float
  {
    if (! $this->relationLoaded('reviews')) {
      $this->load('reviews');
    }

    if ($this->reviews->count() === 0) {
      return null;
    }

    return round($this->reviews->avg('rating'), 1);
  }

  public function getReviewsCountAttribute(): int
  {
    if (! $this->relationLoaded('reviews')) {
      $this->load('reviews');
    }

    return $this->reviews->count();
  }

  public function getRouteKeyName(): string
  {
    return 'slug';
  }

  public function cartItems()
  {
    return $this->hasMany(CartItem::class);
  }
}

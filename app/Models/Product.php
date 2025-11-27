<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public const DEFAULT_CURRENCY = 'VND';

    protected $fillable = [
        'category_id',
        'price',
        'name',
        'description',
        'currency',
        'display_image_url',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $appends = [
        'formatted_price',
    ];

    /**
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        $currency = $this->currency ?? self::DEFAULT_CURRENCY;
        $amount = number_format((float) $this->price, 0, '.', ',');

        return sprintf('%s %s', $amount, $currency);
    }

    public function getDisplayImageUrlAttribute(): string
    {
        $value = $this->getRawOriginal('display_image_url');

        return $value ?: 'https://images.unsplash.com/photo-1509042239860-f550ce710b93';
    }

    public function getFormattedTotalAmount(int $quantity): string
    {
        $currency = $this->currency ?? self::DEFAULT_CURRENCY;
        $amount = number_format($this->price * max($quantity, 1), 0, '.', ',');

        return sprintf('%s %s', $amount, $currency);
    }
}

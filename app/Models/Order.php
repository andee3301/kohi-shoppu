<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'user_id',
        'code',
        'full_name',
        'phone_number',
        'email',
        'shipping_address',
        'coupon_code',
        'notes',
        'status',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }

    public function getCheckoutConfirmtionPath(): string
    {
        return URL::signedRoute('checkout.show', ['order' => $this->id]);
    }

    public function getOrderNumberAttribute(): string
    {
        return $this->code;
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->full_name;
    }

    public function getCustomerEmailAttribute(): string
    {
        return $this->email;
    }

    public function getTotalAttribute(): float
    {
        return $this->cart?->total_amount ?? 0.0;
    }
}

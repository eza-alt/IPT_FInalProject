<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'preparing', 'completed', 'cancelled'];

    protected $fillable = ['customer_name', 'order_date', 'status', 'total_amount', 'notes'];

    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // hasOne example: the most recently added item of this order
    public function latestItem(): HasOne
    {
        return $this->hasOne(OrderItem::class)->latestOfMany();
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'preparing'], true);
    }

    public function recalculateTotal(): void
    {
        $this->update(['total_amount' => $this->items()->sum('subtotal')]);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'preparing' => 'bg-info text-dark',
            'completed' => 'bg-success',
            'cancelled' => 'bg-secondary',
            default => 'bg-light text-dark',
        };
    }
}
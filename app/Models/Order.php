<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_courier',
        'shipping_cost',
        'grand_total',
        'payment_status',
        'payment_proof',
        'snap_token',
        'payment_type',
        'payment_bank',
        'va_number',
        'payment_qr_url',
        'payment_code',
        'payment_deeplink_url',
        'payment_expired_at',
        'paid_at',
        'order_status',
        'tracking_number',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'payment_expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedGrandTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (!$this->payment_proof) {
            return null;
        }
        if (str_starts_with($this->payment_proof, 'http')) {
            return $this->payment_proof;
        }
        return asset('storage/' . $this->payment_proof);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isExpired(): bool
    {
        if ($this->payment_status === 'expired' || $this->order_status === 'cancelled') {
            return true;
        }
        if ($this->payment_status === 'unpaid' && $this->payment_expired_at && $this->payment_expired_at->isPast()) {
            return true;
        }
        return false;
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status === 'unpaid' && !$this->isExpired();
    }

    public function getFormattedPaymentTypeAttribute(): string
    {
        if ($this->payment_type === 'manual_transfer') {
            return 'Transfer Bank Manual';
        }

        $bank = strtoupper($this->payment_bank ?? '');

        switch ($this->payment_type) {
            case 'bank_transfer':
            case 'echannel':
            case 'permata':
                return $bank ? "Virtual Account {$bank}" : 'Virtual Account';
            case 'qris':
                return 'QRIS (Gopay/OVO/Dana/LinkAja/ShopeePay)';
            case 'gopay':
                return 'GoPay';
            case 'shopeepay':
                return 'ShopeePay';
            case 'cstore':
                return $bank ? "Gerai {$bank}" : 'Gerai / Convenience Store';
            case 'credit_card':
                return 'Kartu Kredit / Debit';
            default:
                return $this->payment_type ? ucfirst(str_replace('_', ' ', $this->payment_type)) : 'Midtrans Payment';
        }
    }
}

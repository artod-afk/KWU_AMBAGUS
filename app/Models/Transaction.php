<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'total_amount', 'paid_amount', 'change_amount', 'total_items', 'notes'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // Generate kode transaksi unik
    public static function generateCode(): string
    {
        $date  = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'TRX-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}

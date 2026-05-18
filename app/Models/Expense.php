<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'purchase_price',
        'total',
        'supplier',
        'transaction_date',
        'notes'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'purchase_price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'selling_price',
        'total',
        'transaction_date',
        'notes'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'selling_price' => 'decimal:2',
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

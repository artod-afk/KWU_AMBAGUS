<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'notes',
        'source',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Helper: catat history dengan mudah
     * Fallback jika kolom notes/source belum ada di database
     */
    public static function log(int $productId, string $type, int $quantity, string $notes = '', string $source = 'manual_add'): self
    {
        $data = [
            'product_id' => $productId,
            'type'       => $type,
            'quantity'   => $quantity,
        ];

        // Cek apakah kolom notes & source sudah ada
        try {
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('stock_histories');
            if (in_array('notes', $columns)) {
                $data['notes'] = $notes;
            }
            if (in_array('source', $columns)) {
                $data['source'] = $source;
            }
        } catch (\Exception $e) {
            // Abaikan jika gagal cek kolom
        }

        return self::create($data);
    }
}

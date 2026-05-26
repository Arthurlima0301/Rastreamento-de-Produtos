<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'item_number',
        'shipping_code',
        'roll',
        'width',
        'length',
        'sheets',
        'grammage',
        'expedition_code',
        'paper',
        'return_lot',
        'packages',
        'net_weight_p',
        'gross_weight_p',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'grammage' => 'decimal:2',
        'net_weight_p' => 'decimal:2',
        'gross_weight_p' => 'decimal:2',
    ];

    /**
     * Formatter grammage attribute accessor.
     */
    public function getFormattedGrammageAttribute(): string
    {
        return number_format($this->grammage, 2, ',', '.');
    }

    /**
     * Formatter net weight attribute accessor.
     */
    public function getFormattedNetWeightPAttribute(): string
    {
        return number_format($this->net_weight_p, 2, ',', '.');
    }

    /**
     * Formatter gross weight attribute accessor.
     */
    public function getFormattedGrossWeightPAttribute(): string
    {
        return number_format($this->gross_weight_p, 2, ',', '.');
    }

    /**
     * Get the order that owns the material.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope a query to search materials by paper.
     */
    public function scopeSearchByPaper($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('paper', 'like', $search.'%');
        });
    }
}

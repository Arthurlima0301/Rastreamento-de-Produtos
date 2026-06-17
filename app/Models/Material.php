<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'item_number',
        'shipment_code',
        'roll',
        'width',
        'length',
        'sheets',
        'grammage',
        'expedition_code',
        'paper',
        'return_batch',
        'packages',
        'package_net_weight',
        'package_gross_weight',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'grammage' => 'decimal:2',
        'package_net_weight' => 'decimal:2',
        'package_gross_weight' => 'decimal:2',
    ];

    /**
     * Format the grammage attribute.
     */
    public function getFormattedGrammageAttribute(): string
    {
        return $this->formatDecimal($this->grammage);
    }

    /**
     * Format the package net weight attribute.
     */
    public function getFormattedPackageNetWeightAttribute(): string
    {
        return $this->formatDecimal($this->package_net_weight);
    }

    /**
     * Format the package gross weight attribute.
     */
    public function getFormattedPackageGrossWeightAttribute(): string
    {
        return $this->formatDecimal($this->package_gross_weight);
    }

    /**
     * Format a decimal value for display.
     */
    private function formatDecimal($value): string
    {
        return number_format((float) $value, 2, ',', '.');
    }

    /**
     * Get the order that owns the material.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the item materials for the material.
     */
    public function itemMaterials(): HasMany
    {
        return $this->hasMany(ItemMaterial::class, 'material_id');
    }

    /**
     * Scope a query to search materials by paper.
     */
    public function scopeSearchByPaper($query, $search)
    {
        $search = trim($search);
        if ($search) {
            $query->where('paper', 'like', '%' . $search . '%');
        }

        return $query;
    }
}

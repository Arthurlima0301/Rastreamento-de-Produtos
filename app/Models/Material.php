<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

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

    protected $casts = [
        'grammage' => 'decimal:2',
        'package_net_weight' => 'decimal:2',
        'package_gross_weight' => 'decimal:2',
    ];

    public function getFormattedGrammageAttribute(): string
    {
        return $this->formatDecimal($this->grammage);
    }

    public function getFormattedPackageNetWeightAttribute(): string
    {
        return $this->formatDecimal($this->package_net_weight);
    }

    public function getFormattedPackageGrossWeightAttribute(): string
    {
        return $this->formatDecimal($this->package_gross_weight);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function itemMaterials(): HasMany
    {
        return $this->hasMany(ItemMaterial::class, 'material_id');
    }

    private function formatDecimal($value): string
    {
        return number_format((float) $value, 2, ',', '.');
    }
}

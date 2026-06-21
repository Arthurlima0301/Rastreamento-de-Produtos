<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemMaterial extends Model
{
    use HasFactory;

    protected $table = 'item_material';

    protected $fillable = [
        'number',
        'material_id',
        'material_invoice_id',
        'total_weight',
        'pallets_quantity',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected $casts = [
        'number' => 'integer',
        'total_weight' => 'float',
        'pallets_quantity' => 'integer',
    ];

    /**
     * Get Formatted Total Weight Attribute
     */
    public function getFormattedTotalWeightAttribute(): string
    {
        return number_format((float) $this->total_weight, 2, ',', '.');
    }

    /**
     * Get the material associated with the item material.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    /**
     * Get the material invoice associated with the item material.
     */
    public function materialInvoice(): BelongsTo
    {
        return $this->belongsTo(MaterialInvoice::class, 'material_invoice_id');
    }

    /**
     * Get the rolls associated with the item material.
     */
    public function rolls(): HasMany
    {
        return $this->hasMany(Roll::class, 'item_material_id');
    }

    /**
     * Scope a query to search item materials by material paper.
     */
    public function scopeSearchByMaterialPaper($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->whereHas('material', function ($query) use ($search) {
                $query->where('paper', 'like', $search.'%');
            });
        });
    }
}

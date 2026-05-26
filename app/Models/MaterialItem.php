<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'material_id',
        'material_invoice_id',
        'roll_quantity',
        'weight',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'roll_quantity' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    /**
     * Formatter roll quantity attribute accessor.
     */
    public function getFormattedRollQuantityAttribute(): string
    {
        return number_format($this->roll_quantity, 2, ',', '.');
    }

    /**
     * Formatter weight attribute accessor.
     */
    public function getFormattedWeightAttribute(): string
    {
        return number_format($this->weight, 2, ',', '.');
    }

    /**
     * Get the material that owns the material item.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    /**
     * Get the material invoice that owns the material item.
     */
    public function materialInvoice(): BelongsTo
    {
        return $this->belongsTo(MaterialInvoice::class, 'material_invoice_id');
    }

    /**
     * Scope a query to search material items by material paper.
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

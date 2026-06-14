<?php

namespace App\Models;

use Database\Factories\RollFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roll extends Model
{
    /** @use HasFactory<RollFactory> */
    use HasFactory;

    protected $table = 'rolls';

    protected $fillable = [
        'label',
        'weight',
        'status',
        'defect',
        'defect_weight',
        'item_material_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'weight' => 'float',
        'defect_weight' => 'float',
    ];

    /**
     * Formatted weight attribute accessor.
     */
    public function getFormattedWeightAttribute()
    {
        return number_format($this->weight, 0, ',', '.');
    }

    /**
     * Formatted defect weight attribute accessor.
     */
    public function getFormattedDefectWeightAttribute()
    {
        return number_format($this->defect_weight, 0, ',', '.');
    }

    /**
     * Get the item material that owns the roll.
     */
    public function itemMaterial(): BelongsTo
    {
        return $this->belongsTo(ItemMaterial::class);
    }

    /**
     * Get the load that owns the roll.
     */
    public function cutLoad(): BelongsTo
    {
        return $this->belongsTo(Load::class, 'load_id');
    }

    /**
     * Scope a query to search rolls by label.
     */
    public function scopeSearchByLabel($query, string $search)
    {
        $search = trim($search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('label', 'like', $search.'%');
        });
    }

    /**
     * Scope a query to filter rolls by status.
     */
    public function scopeFilterByStatus($query, string $status)
    {
        return $query->when($status !== '', function ($query) use ($status) {
            $query->where('status', $status);
        });
    }
}

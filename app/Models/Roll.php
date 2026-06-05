<?php

namespace App\Models;

use Database\Factories\RollFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    /** @use HasFactory<RollFactory> */
    use HasFactory;

    protected $table = 'rolls';

    protected $fillable = [
        'label',
        'weight',
        'status',
        'item_material_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'weight' => 'float',
    ];

    /**
     * Formatted weight attribute accessor.
     */
    public function getFormattedWeightAttribute()
    {
        return number_format($this->weight, 0, ',', '.');
    }

    /**
     * Get the item material that owns the roll.
     */
    public function item_material()
    {
        return $this->belongsTo(ItemMaterial::class);
    }

    /**
     * Scope a query to search rolls by label.
     */
    public function scopeSearchByLabel($query, $search)
    {
        $search = trim($search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('label', 'like', $search . '%');
        });
    }

    /**
     * Scope a query to filter rolls by status.
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->when($status !== '', function ($query) use ($status) {
            $query->where('status', $status);
        });
    }
}

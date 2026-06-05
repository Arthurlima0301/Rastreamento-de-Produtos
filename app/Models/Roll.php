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
}

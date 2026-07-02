<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pallet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'pallets';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'label',
        'load_id',
        'item_material_id',
        'package_net_weight',
    ];

    /**
     * Get Formatted Pallet Label
     */
    public function getFormattedLabelAttribute(): string
    {
        return str_pad($this->label, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get Formatted Package Net Weight
     */
    public function getFormattedPackageNetWeightAttribute(): string
    {
        return number_format($this->package_net_weight, 2, ',', '.');
    }

    /**
     *  Get the load that owns the pallet.
     */
    public function cutLoad(): BelongsTo
    {
        return $this->belongsTo(Load::class, 'load_id');
    }

    /**
     * Get the item material that owns the pallet.
     */
    public function itemMaterial(): BelongsTo
    {
        return $this->belongsTo(ItemMaterial::class, 'item_material_id');
    }


    /**
     * Search pallets by label.
     */
    public function scopeSearchByLabel($query, $search)
    {
        $search = trim($search);
        $query->when($search, function ($query) use ($search) {
            $query->where('label', '=', "$search");
        });
    }
}
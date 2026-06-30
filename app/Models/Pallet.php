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
     *  Get the load that owns the pallet.
     */
    public function cutLoad(): BelongsTo
    {
        return $this->belongsTo(Load::class);
    }

    /**
     * Get the item material that owns the pallet.
     */
    public function itemMaterial(): BelongsTo
    {
        return $this->belongsTo(ItemMaterial::class);
    }
}
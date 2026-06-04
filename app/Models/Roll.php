<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    /** @use HasFactory<\Database\Factories\RollFactory> */
    use HasFactory;

    protected $table = 'rolls';

    /**
     * 
     */
    protected $fillable = [
        'label',
        'weight',
        'status',
        'item_material_id',
    ];


    /**
     * Get the item material that owns the roll.
     */
    public function item_material()
    {
        return $this->belongsTo(ItemMaterial::class);
    }

}

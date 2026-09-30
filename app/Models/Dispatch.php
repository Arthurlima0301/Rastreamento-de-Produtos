<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispatch extends Model
{
    use HasFactory;

    /** Disable timestamps because table follows schema exactly */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'dispatched_at',
        'item_material_id',
        'invoice',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'dispatched_at' => 'date',
    ];

    /**
     * Accessor to format the 'dispatched_at' attribute as 'd/m/Y' when accessed.
     */
    public function getFormattedDispatchedAtAttribute(): string
    {
        return date('d/m/Y', strtotime($this->dispatched_at));
    }

    /**
     * Get the dispatch items for the dispatch.
     */
    public function dispatchItems(): HasMany
    {
        return $this->hasMany(DispatchItem::class, 'dispatch_id');
    }

    /**
     *  Get the pallets for the dispatch.
     */
    public function pallets() : HasMany {
        return $this->hasMany(Pallet::class, 'dispatch_id');
    }

    /**
     *  Get the item material for the dispatch.
     */
    public function itemMaterial() : BelongsTo {
        return $this->belongsTo(ItemMaterial::class, 'item_material_id');
    }

    /**
     * Scope a query to search dispatches by invoice.
     */
    public function scopeSearchByInvoice($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('invoice', 'like', $search.'%');
        });
    }
}
